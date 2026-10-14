<?php

namespace Supertext\PimcoreTranslationBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Supertext\PimcoreTranslationBundle\Api\LanguageCodes;
use Supertext\PimcoreTranslationBundle\Api\SupertextException;

/** Pimcore languages → Supertext codes: the mapping, else an exact Supertext code, else unsupported-language. No guessing. */
final class LanguageCodesTest extends TestCase
{
    public function testUsesPimcoreCodesThatAreSupertextCodes(): void
    {
        self::assertSame('de-CH', LanguageCodes::target('de_CH'));
        self::assertSame('de-CH', LanguageCodes::target('de-ch'));
        self::assertSame('en-GB', LanguageCodes::target('EN_gb'));
        self::assertSame('zh-Hant', LanguageCodes::target('zh_hant'));
        self::assertSame('es', LanguageCodes::target('es'));
        self::assertSame('sl', LanguageCodes::target('sl'));
    }

    public function testGuessesNoRegion(): void
    {
        foreach (['de', 'en', 'fr', 'zh', 'es_ES', 'sl_SI', 'zh_CN', 'xx'] as $language) {
            self::assertNull(LanguageCodes::targetOrNull($language), $language);
        }

        try {
            LanguageCodes::target('de');
            self::fail('Expected an exception');
        } catch (SupertextException $e) {
            self::assertSame('unsupported-language', $e->key);
            self::assertSame(['language' => 'de'], $e->params);
            self::assertStringStartsWith('The language de has no Supertext language yet.', $e->getMessage());
        }
    }

    public function testTheMappingWins(): void
    {
        $mapping = ['de' => 'de-CH', 'en' => 'en-US', 'zh_CN' => 'zh-Hans', 'fr_FR' => ' fr-CH ', 'it' => '  '];

        self::assertSame('de-CH', LanguageCodes::target('de', $mapping));
        self::assertSame('zh-Hans', LanguageCodes::target('zh-cn', $mapping), 'keys compared ignoring case and _/-');
        self::assertSame('fr-CH', LanguageCodes::target('fr_FR', $mapping));
        self::assertNull(LanguageCodes::targetOrNull('it', $mapping), 'a blank entry is no mapping');
        self::assertSame('ab-CD', LanguageCodes::target('ab', ['ab' => 'ab-CD']), 'a code the SDK does not list is sent as it is');
    }

    public function testSourcesAreBareAndShareTheMapping(): void
    {
        self::assertSame('en', LanguageCodes::source('en'));
        self::assertSame('en', LanguageCodes::source('en_GB'));
        self::assertSame('de', LanguageCodes::source('de_CH'));
        self::assertSame('', LanguageCodes::source(''));
        self::assertSame('en', LanguageCodes::source('en', ['en' => 'en-US']), 'a mapped target code is sent in its source form');
        self::assertSame('pt', LanguageCodes::source('br', ['br' => 'pt-BR']));

        $this->expectException(SupertextException::class);
        LanguageCodes::source('xx');
    }

    public function testPolitenessOnlyWhereSupertextOffersIt(): void
    {
        self::assertSame('more', LanguageCodes::politeness('de-CH', 'more'));
        self::assertSame('default', LanguageCodes::politeness('en-US', ''));
        self::assertSame('less', LanguageCodes::politeness('ab-CD', 'less'), 'unknown codes: Supertext decides');
        self::assertTrue(LanguageCodes::supportsPoliteness('fr-CH'));
        self::assertFalse(LanguageCodes::supportsPoliteness('en-US'));

        try {
            LanguageCodes::politeness('en-US', 'more');
            self::fail('A configured tone is never dropped silently');
        } catch (SupertextException $e) {
            self::assertSame('unsupported-feature', $e->key);
        }
    }

    public function testListsTheTargets(): void
    {
        $codes = array_column(LanguageCodes::targets(), 'code');
        self::assertContains('de-CH', $codes);
        self::assertContains('es', $codes);
        self::assertNotContains('es-ES', $codes);
    }
}
