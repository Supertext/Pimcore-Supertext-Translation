<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Service;

use Supertext\PimcoreTranslationBundle\Api\HtmlDocument;
use Supertext\PimcoreTranslationBundle\Api\SupertextClient;
use Supertext\PimcoreTranslationBundle\Api\SupertextException;
use Supertext\PimcoreTranslationBundle\Settings;

/**
 * Sends values to Supertext as one HTML document per target language (one data-st-id
 * element per value; chunked below the API's size limit) and returns the translations.
 */
final class SegmentTranslator
{
    private ?SupertextClient $client = null;

    public function __construct(private readonly Settings $settings)
    {
    }

    public function setClient(SupertextClient $client): void
    {
        $this->client = $client;
    }

    public function assertConfigured(): void
    {
        if ($this->client === null && $this->settings->apiKey() === '') {
            throw new SupertextException(
                'No Supertext API key is configured. Set the SUPERTEXT_API_KEY environment variable. ' . Settings::KEY_HELP
            );
        }
    }

    /**
     * @param array<int|string, array{text: string, html: bool}> $segments
     *
     * @return array<int|string, string> segment key => translation (missing keys: not translated)
     */
    public function translate(array $segments, string $sourceLanguage, string $targetLanguage): array
    {
        if ($segments === []) {
            return [];
        }
        $this->assertConfigured();
        $client = $this->client ?? $this->settings->client();

        // HtmlDocument works with integer ids; map them back to the caller's keys.
        $keys = array_keys($segments);
        $indexed = array_values($segments);
        $source = strtolower(explode('-', $this->settings->languageCode($sourceLanguage))[0]);
        $out = [];
        foreach (HtmlDocument::chunks($indexed) as $chunk) {
            try {
                $html = $client->translateDocument(
                    HtmlDocument::build($chunk),
                    $this->settings->languageCode($targetLanguage),
                    $source,
                    $this->settings->politeness($targetLanguage) ?: 'default'
                );
            } catch (SupertextException $e) {
                throw Settings::withKeyHelp($e);
            }
            $isHtml = array_map(static fn (array $s): bool => $s['html'], $chunk);
            foreach (HtmlDocument::parse($html, $isHtml) as $i => $translation) {
                $out[$keys[$i]] = $translation;
            }
        }

        return $out;
    }
}
