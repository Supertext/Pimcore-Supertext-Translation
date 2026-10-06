<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle;

use Supertext\PimcoreTranslationBundle\Api\SupertextClient;
use Supertext\PimcoreTranslationBundle\Api\SupertextException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Settings (bundle config + SUPERTEXT_API_KEY / SUPERTEXT_API_URL) and the API client.
 */
final class Settings
{
    public const PERMISSION = 'supertext_translate';

    public const SIGNUP_URL = 'https://www.supertext.com/person/en/account/signin';
    public const API_KEY_URL = 'https://www.supertext.com/en/integrations/api';

    public function __construct(
        #[Autowire(param: 'supertext_translation.config')]
        private readonly array $config,
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function apiKey(): string
    {
        return SupertextClient::normalizeKey((string) ($_SERVER['SUPERTEXT_API_KEY'] ?? $_ENV['SUPERTEXT_API_KEY'] ?? getenv('SUPERTEXT_API_KEY') ?: ''));
    }

    public function apiKeySource(): string
    {
        return $this->apiKey() !== '' ? 'environment' : '';
    }

    public function baseUrl(): string
    {
        $url = (string) ($_SERVER['SUPERTEXT_API_URL'] ?? $_ENV['SUPERTEXT_API_URL'] ?? getenv('SUPERTEXT_API_URL') ?: $this->config['api_url']);

        return SupertextClient::baseUrlFor((string) $this->config['environment'], $url);
    }

    public function timeout(): int
    {
        return (int) $this->config['timeout'];
    }

    /** Supertext language for a Pimcore language: the configured code, else BCP-47 (de_CH -> de-CH). */
    public function languageCode(string $language): string
    {
        $code = trim((string) ($this->config['languages'][$language]['code'] ?? ''));

        return $code !== '' ? $code : str_replace('_', '-', $language);
    }

    /** "more", "less" or "" (default). */
    public function politeness(string $language): string
    {
        $value = (string) ($this->config['languages'][$language]['politeness'] ?? '');

        return \in_array($value, ['more', 'less'], true) ? $value : '';
    }

    /** @return list<string> */
    public function objectFieldTypes(): array
    {
        return array_values($this->config['object_field_types']);
    }

    /** @return list<string> */
    public function documentEditableTypes(): array
    {
        return array_values($this->config['document_editable_types']);
    }

    public function client(): SupertextClient
    {
        $http = $this->httpClient;
        $transport = static function (string $method, string $url, array $headers, ?string $body) use ($http): array {
            try {
                $response = $http->request($method, $url, ['headers' => $headers, 'body' => $body ?? '', 'timeout' => 60]);
                $out = [];
                foreach ($response->getHeaders(false) as $name => $values) {
                    $out[strtolower($name)] = implode(', ', $values);
                }

                return ['status' => $response->getStatusCode(), 'body' => $response->getContent(false), 'headers' => $out];
            } catch (TransportExceptionInterface $e) {
                throw new SupertextException('The Supertext service could not be reached. ' . $e->getMessage());
            }
        };

        return new SupertextClient($this->apiKey(), $this->baseUrl(), $transport, $this->timeout(), (float) $this->config['poll_interval']);
    }
}
