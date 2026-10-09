<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** The Studio strings exist in English, German, French and Italian, with the same keys, placeholders and links. */
final class StudioTranslationsTest extends TestCase
{
    private const DIR = __DIR__ . '/../../translations/';

    /** @return iterable<string, array{string}> */
    public static function languages(): iterable
    {
        foreach (['de', 'fr', 'it'] as $language) {
            yield $language => [$language];
        }
    }

    #[DataProvider('languages')]
    public function testSameKeysPlaceholdersAndLinksAsEnglish(string $language): void
    {
        $english = self::strings('en');
        $strings = self::strings($language);

        self::assertSame(array_keys($english), array_keys($strings), "studio.$language.yaml has other keys than English");

        foreach ($english as $key => $text) {
            self::assertNotSame('', trim($strings[$key]), "$language: $key is empty");
            self::assertSame(self::found('/\{\{\s*\w+\s*\}\}/', $text), self::found('/\{\{\s*\w+\s*\}\}/', $strings[$key]), "$language: placeholders of $key");
            self::assertSame(self::found('#https?://[^\s,)]+#', $text), self::found('#https?://[^\s,)]+#', $strings[$key]), "$language: links of $key");
        }
    }

    /** Every error key the PHP code sends (key: '…', 'key' => '…', the HTTP status match) has an English text. */
    public function testServerKeysHaveTexts(): void
    {
        $english = self::strings('en');
        $keys    = [];

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/../../src', \FilesystemIterator::SKIP_DOTS)) as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $code = (string) file_get_contents($file->getPathname());
                preg_match_all("/(?:key: |'key' => |\\d{3}, |=> \\[)'([a-z][a-z-]*)'(?=[,\\]\\)])/", $code, $matches);
                $keys = array_merge($keys, $matches[1]);
            }
        }

        $keys = array_unique($keys);
        self::assertGreaterThan(20, \count($keys));

        foreach ($keys as $key) {
            self::assertArrayHasKey('supertext.error.' . $key, $english, "no English text for the server key $key");
        }

        // Added after these messages by the Studio dialog
        self::assertArrayHasKey('supertext.error.key-help', $english);
    }

    /** @return array<string, string> key (sorted) => text */
    private static function strings(string $language): array
    {
        $path = self::DIR . "studio.$language.yaml";
        self::assertFileExists($path);
        $strings = [];

        foreach (file($path, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
            if (trim($line) === '') {
                continue;
            }
            self::assertSame(1, preg_match("/^([A-Za-z0-9_.-]+): '((?:[^']|'')*)'$/", $line, $m), "$language: write every line as key: 'value' ($line)");
            $strings[$m[1]] = str_replace("''", "'", $m[2]);
        }

        ksort($strings);

        return $strings;
    }

    /** @return list<string> */
    private static function found(string $pattern, string $text): array
    {
        preg_match_all($pattern, $text, $matches);
        $list = array_map(static fn (string $m): string => preg_replace('/\s+/', '', $m), $matches[0]);
        sort($list);

        return $list;
    }
}
