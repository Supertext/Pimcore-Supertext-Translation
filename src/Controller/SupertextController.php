<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Controller;

use Pimcore\Bundle\StudioBackendBundle\Controller\AbstractApiController;
use Pimcore\Bundle\StudioBackendBundle\Security\Service\SecurityServiceInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\Document;
use Pimcore\Model\Document\PageSnippet;
use Pimcore\Model\User;
use Pimcore\Tool;
use Psr\Log\LoggerInterface;
use Supertext\PimcoreTranslationBundle\Api\SupertextException;
use Supertext\PimcoreTranslationBundle\Service\DocumentTranslator;
use Supertext\PimcoreTranslationBundle\Service\ObjectTranslator;
use Supertext\PimcoreTranslationBundle\Settings;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Studio API endpoints (behind Studio's login, under /pimcore-studio/api):
 *
 *   GET  /supertext/elements/{type}/{id}             languages and their state for the translate dialog
 *   POST /supertext/elements/{type}/{id}/translate   {source?, targets[], overwrite}
 *   GET  /supertext/settings                         API key status, API address, languages (admins)
 *   POST /supertext/settings/test                    checks the API key, cost-free (admins)
 *
 * {type} is "document" or "data-object".
 */
final class SupertextController extends AbstractApiController
{
    public function __construct(
        SerializerInterface $serializer,
        private readonly SecurityServiceInterface $security,
        private readonly Settings $settings,
        private readonly ObjectTranslator $objects,
        private readonly DocumentTranslator $documents,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct($serializer);
    }

    #[Route('/supertext/elements/{type}/{id}', name: 'supertext_translation_element', requirements: ['type' => 'document|data-object', 'id' => '\d+'], methods: ['GET'])]
    public function element(string $type, int $id): JsonResponse
    {
        $user = $this->user();
        if (!$user->isAllowed(Settings::PERMISSION)) {
            return $this->error('You are not allowed to translate with Supertext.', 403, 'not-allowed');
        }
        $element = $this->load($type, $id);
        if (!$element || !$element->isAllowed('view', $user)) {
            return $this->error('Not found.', 404, 'element-not-found');
        }

        $common = [
            'configured' => $this->settings->apiKey() !== '',
            'signupUrl' => Settings::SIGNUP_URL,
            'apiKeyUrl' => Settings::API_KEY_URL,
            'isAdmin' => $user->isAdmin(),
        ];
        if ($element instanceof PageSnippet) {
            $info = $this->documents->describe($element, $user);

            return new JsonResponse($common + ['type' => 'document', 'source' => $info['source'], 'languages' => $info['languages']]);
        }

        return new JsonResponse($common + ['type' => 'data-object', 'fields' => array_keys($this->objects->fields($element)), 'languages' => $this->objects->describe($element, $user)]);
    }

    #[Route('/supertext/elements/{type}/{id}/translate', name: 'supertext_translation_translate', requirements: ['type' => 'document|data-object', 'id' => '\d+'], methods: ['POST'])]
    public function translate(string $type, int $id, Request $request): JsonResponse
    {
        $user = $this->user();
        if (!$user->isAllowed(Settings::PERMISSION)) {
            return $this->error('You are not allowed to translate with Supertext.', 403, 'not-allowed');
        }
        $element = $this->load($type, $id);
        if (!$element || !$element->isAllowed('view', $user)) {
            return $this->error('Not found.', 404, 'element-not-found');
        }
        $payload = json_decode($request->getContent() ?: '[]', true) ?: [];
        $targets = array_values(array_filter((array) ($payload['targets'] ?? []), 'is_string'));
        if ($targets === []) {
            return $this->error('Choose at least one language to translate into.', 400, 'choose-target');
        }
        $overwrite = (bool) ($payload['overwrite'] ?? false);
        @set_time_limit(max(300, $this->settings->timeout() * (\count($targets) + 1)));

        try {
            $results = $element instanceof PageSnippet
                ? $this->documents->translate($element, $targets, $overwrite, $user)
                : $this->objects->translate($element, (string) ($payload['source'] ?? ''), $targets, $overwrite, $user);
        } catch (SupertextException $e) {
            $this->logger->warning('Supertext translation failed: ' . $e->getMessage(), ['type' => $type, 'id' => $id]);

            return new JsonResponse(['error' => $e->getMessage()] + $e->toArray(), 400);
        } catch (\Throwable $e) {
            $this->logger->error('Supertext translation failed: ' . $e->getMessage(), ['exception' => $e]);

            return $this->error($e->getMessage(), 500);
        }

        foreach ($results as $result) {
            if ($result['status'] === 'error') {
                $this->logger->warning(sprintf('Supertext translation into %s failed: %s', $result['language'], $result['message']), ['type' => $type, 'id' => $id]);
            }
        }

        return new JsonResponse(['results' => $results]);
    }

    #[Route('/supertext/settings', name: 'supertext_translation_settings', methods: ['GET'])]
    public function settings(): JsonResponse
    {
        $user = $this->user();
        if (!$user->isAllowed(Settings::PERMISSION) && !$user->isAdmin()) {
            return $this->error('You are not allowed to see the Supertext settings.', 403);
        }
        $languages = [];
        foreach (Tool::getValidLanguages() as $language) {
            $languages[] = [
                'language' => $language,
                'name' => \Locale::getDisplayName($language, $user->getLanguage() ?: 'en'),
                'code' => $this->settings->languageCode($language),
                'politeness' => $this->settings->politeness($language),
            ];
        }

        return new JsonResponse([
            'configured' => $this->settings->apiKey() !== '',
            'apiKeySource' => $this->settings->apiKeySource(),
            'apiUrl' => $this->settings->baseUrl(),
            'timeout' => $this->settings->timeout(),
            'languages' => $languages,
            'signupUrl' => Settings::SIGNUP_URL,
            'apiKeyUrl' => Settings::API_KEY_URL,
            'isAdmin' => $user->isAdmin(),
        ]);
    }

    #[Route('/supertext/settings/test', name: 'supertext_translation_test', methods: ['POST'])]
    public function test(): JsonResponse
    {
        if (!$this->user()->isAdmin()) {
            return $this->error('Only administrators can test the connection.', 403);
        }
        if ($this->settings->apiKey() === '') {
            return $this->error('No Supertext API key is configured. Set the SUPERTEXT_API_KEY environment variable. ' . Settings::KEY_HELP, 400);
        }
        try {
            $this->settings->client()->validateApiKey();
        } catch (SupertextException $e) {
            return $this->error(Settings::withKeyHelp($e)->getMessage(), 502);
        }

        return new JsonResponse(['ok' => true, 'message' => 'Connected. The API key works.']);
    }

    private function user(): User
    {
        $user = $this->security->getCurrentUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $user;
    }

    private function load(string $type, int $id): PageSnippet|Concrete|null
    {
        $element = $type === 'document' ? Document::getById($id) : Concrete::getById($id);

        return $element instanceof PageSnippet || $element instanceof Concrete ? $element : null;
    }

    /** @param string $key the UI shows `supertext.error.<key>` (translations/studio.*.yaml) instead of the English message */
    private function error(string $message, int $status, string $key = ''): JsonResponse
    {
        return new JsonResponse(['error' => $message, 'key' => $key], $status);
    }
}
