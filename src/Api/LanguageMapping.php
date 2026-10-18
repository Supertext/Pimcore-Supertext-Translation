<?php

/**
 * @package     Supertext Translation for Pimcore
 * @copyright   (C) Supertext AG
 * @license     MIT
 */

namespace Supertext\PimcoreTranslationBundle\Api;

use Supertext\PimcoreTranslationBundle\Sdk\V1\Languages;

/**
 * The language mapping as administrators set it on the *Supertext* settings screen (one select per
 * Pimcore language, stored in Pimcore's settings store) combined with the bundle configuration
 * (`supertext_translation.languages.<language>.code` / `.politeness`), which wins where it is set.
 * No Pimcore classes: unit-tested on its own.
 *
 * Stored form: `{"<pimcore language>": {"code": "<Supertext target code or ''>", "politeness": "more"|"less"|""}}`.
 */
final class LanguageMapping
{
    /**
     * @param array<string, array{code?: mixed, politeness?: mixed}|mixed> $config the bundle configuration's `languages`
     * @param array<string, mixed>                                          $stored what the settings screen saved
     */
    public function __construct(
        private readonly array $config = [],
        private readonly array $stored = [],
    ) {
    }

    /** The code set in the bundle configuration (it wins over the screen), or null. */
    public function configCode(string $language): ?string
    {
        $code = trim((string) ($this->entry($this->config, $language)['code'] ?? ''));

        return $code !== '' ? $code : null;
    }

    /** The code chosen on the settings screen ('' while nothing is saved). */
    public function savedCode(string $language): string
    {
        return trim((string) ($this->entry($this->stored, $language)['code'] ?? ''));
    }

    /** The tone set in the bundle configuration ("more", "less", "default"), or null. */
    public function configPoliteness(string $language): ?string
    {
        $value = (string) ($this->entry($this->config, $language)['politeness'] ?? '');

        return \in_array($value, ['default', 'more', 'less'], true) ? $value : null;
    }

    /** The tone to use: the configuration's, else the screen's; "more", "less" or "" (Supertext's default). */
    public function politeness(string $language): string
    {
        $value = $this->configPoliteness($language) ?? (string) ($this->entry($this->stored, $language)['politeness'] ?? '');

        return \in_array($value, ['more', 'less'], true) ? $value : '';
    }

    /**
     * Pimcore language → Supertext code: the screen's choices, overridden by the configuration (non-blank only).
     * Languages in neither use the SDK's exact match or default (`Languages::target()`).
     *
     * @return array<string, string>
     */
    public function mapping(): array
    {
        $mapping = [];
        foreach (array_keys($this->stored) as $language) {
            $code = $this->savedCode((string) $language);
            if ($code !== '') {
                $mapping[(string) $language] = $code;
            }
        }
        foreach (array_keys($this->config) as $language) {
            $code = $this->configCode((string) $language);
            if ($code !== null) {
                $mapping[(string) $language] = $code;
            }
        }

        return $mapping;
    }

    /**
     * What the settings screen saves: only Pimcore languages that exist, only Supertext's target codes,
     * a tone only where the target offers one.
     *
     * @param array<mixed>  $input     language => {code, politeness}
     * @param list<string>  $languages the Pimcore languages
     *
     * @return array<string, array{code: string, politeness: string}>
     *
     * @throws \InvalidArgumentException for an unknown language or a code Supertext doesn't offer
     */
    public static function validate(array $input, array $languages): array
    {
        $out = [];
        foreach ($input as $language => $row) {
            $language = (string) $language;
            if (!\in_array($language, $languages, true)) {
                throw new \InvalidArgumentException('Unknown language ' . $language . '.');
            }
            $row = \is_array($row) ? $row : [];
            $code = trim((string) ($row['code'] ?? ''));
            if ($code !== '' && !Languages::isSupportedTarget($code)) {
                throw new \InvalidArgumentException('Supertext offers no language ' . $code . '.');
            }
            if ($code !== '') {
                // Supertext's own spelling (de-ch → de-CH).
                $code = (string) Languages::matchTarget($code);
            }
            $politeness = (string) ($row['politeness'] ?? '');
            if (!\in_array($politeness, ['more', 'less'], true) || $code === '' || Languages::supportsPoliteness($code) !== true) {
                $politeness = '';
            }
            $out[$language] = ['code' => $code, 'politeness' => $politeness];
        }

        return $out;
    }

    /**
     * One row of the settings screen.
     *
     * @return array{language: string, saved: string, override: string|null, suggested: string|null, code: string|null, politeness: string, politenessOverride: bool}
     */
    public function row(string $language): array
    {
        return [
            'language' => $language,
            'saved' => $this->savedCode($language),
            'override' => $this->configCode($language),
            'suggested' => Languages::suggestTarget($language),
            'code' => LanguageCodes::targetOrNull($language, $this->mapping()),
            'politeness' => $this->politeness($language),
            'politenessOverride' => $this->configPoliteness($language) !== null,
        ];
    }

    /**
     * The entry for a language, keys compared ignoring case and `_`/`-` (exact key first).
     *
     * @param array<string, mixed> $entries
     *
     * @return array<string, mixed>
     */
    private function entry(array $entries, string $language): array
    {
        if (isset($entries[$language]) && \is_array($entries[$language])) {
            return $entries[$language];
        }
        $wanted = strtolower(str_replace('_', '-', $language));
        foreach ($entries as $key => $value) {
            if (\is_array($value) && strtolower(str_replace('_', '-', (string) $key)) === $wanted) {
                return $value;
            }
        }

        return [];
    }
}
