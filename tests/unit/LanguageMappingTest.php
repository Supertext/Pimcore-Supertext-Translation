<?php

declare(strict_types=1);

namespace Supertext\PimcoreTranslationBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Supertext\PimcoreTranslationBundle\Api\LanguageMapping;

/** The language mapping of the Supertext → Settings screen, with the bundle configuration overriding it. */
final class LanguageMappingTest extends TestCase
{
    public function testTheConfigurationWinsOverTheScreen(): void
    {
        $mapping = new LanguageMapping(
            ['en' => ['code' => 'en-GB', 'politeness' => ''], 'fr_CH' => ['code' => '', 'politeness' => 'less']],
            ['en' => ['code' => 'en-US', 'politeness' => ''], 'de' => ['code' => 'de-CH', 'politeness' => 'more'], 'fr_CH' => ['code' => 'fr-FR', 'politeness' => 'more'], 'it' => ['code' => '', 'politeness' => '']],
        );

        self::assertSame(['en' => 'en-GB', 'de' => 'de-CH', 'fr_CH' => 'fr-FR'], $mapping->mapping());
        self::assertSame('more', $mapping->politeness('de'));
        self::assertSame('less', $mapping->politeness('fr_CH'), 'the configured tone wins');
        self::assertSame('', $mapping->politeness('en'));
        self::assertSame('en-GB', $mapping->configCode('en'));
        self::assertNull($mapping->configCode('de'));
        self::assertSame('de-CH', $mapping->savedCode('de'));
    }

    public function testRowsPreselectTheSuggestion(): void
    {
        $mapping = new LanguageMapping(['en' => ['code' => 'en-GB']], ['it' => ['code' => 'it-CH', 'politeness' => 'more']]);

        $de = $mapping->row('de');
        self::assertSame('', $de['saved']);
        self::assertSame('de-DE', $de['suggested'], 'the SDK default');
        self::assertSame('de-DE', $de['code'], 'what a translation sends');
        self::assertNull($de['override']);

        $it = $mapping->row('it');
        self::assertSame('it-CH', $it['saved']);
        self::assertSame('it-CH', $it['code']);
        self::assertSame('more', $it['politeness']);

        $en = $mapping->row('en');
        self::assertSame('en-GB', $en['override']);
        self::assertSame('en-GB', $en['code']);

        $li = $mapping->row('de_LI');
        self::assertNull($li['suggested'], 'no default: "— choose —"');
        self::assertNull($li['code'], 'not translatable until mapped');
        self::assertSame('de-CH', $mapping->row('de_CH')['suggested'], 'exact match');
    }

    public function testValidateKeepsOnlyKnownLanguagesAndSupertextCodes(): void
    {
        $saved = LanguageMapping::validate([
            'en' => ['code' => 'en-gb', 'politeness' => 'more'],
            'de_CH' => ['code' => 'de-CH', 'politeness' => 'more'],
            'fr' => ['code' => '', 'politeness' => 'less'],
        ], ['en', 'de_CH', 'fr']);

        self::assertSame([
            'en' => ['code' => 'en-GB', 'politeness' => ''],          // Supertext's spelling; English has no tone
            'de_CH' => ['code' => 'de-CH', 'politeness' => 'more'],
            'fr' => ['code' => '', 'politeness' => ''],               // no code chosen: the default, no tone
        ], $saved);
    }

    public function testValidateRefusesUnknownCodes(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        LanguageMapping::validate(['de' => ['code' => 'de-LI']], ['de']);
    }

    public function testValidateRefusesUnknownLanguages(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        LanguageMapping::validate(['xx' => ['code' => 'de-CH']], ['de']);
    }
}
