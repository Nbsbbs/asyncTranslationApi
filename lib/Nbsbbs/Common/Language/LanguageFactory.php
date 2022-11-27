<?php

namespace Nbsbbs\Common\Language;

class LanguageFactory
{
    protected const CODES_TO_LANGUAGES = [
        'en' => EnglishLanguage::class,
        'cs' => ChechLanguage::class,
        'da' => DanishLanguage::class,
        'de' => GermanLanguage::class,
        'es' => SpanishLanguage::class,
        'fr' => FrenchLanguage::class,
        'it' => ItalianLanguage::class,
        'hu' => MagyarLanguage::class,
        'nl' => NederlandsLanguage::class,
        'no' => NorskLanguage::class,
        'pl' => PolishLanguage::class,
        'pt' => PortugueseLanguage::class,
        'sk' => SlovakLanguage::class,
        'sl' => SlovenLanguage::class,
        'fi' => FinnishLanguage::class,
        'sv' => SwedishLanguage::class,
        'el' => GreekLanguage::class,
        'ru' => RussianLanguage::class,
        'ja' => JapaneseLanguage::class,
        'ko' => KoreanLanguage::class,
    ];

    /**
     * @return array
     */
    public static function allCodes(): array
    {
        return array_keys(self::CODES_TO_LANGUAGES);
    }

    /**
     * @param string $code
     * @return bool
     */
    public static function isValidCode(string $code): bool
    {
        return array_key_exists($code, self::CODES_TO_LANGUAGES);
    }

    /**
     * @param string $code
     * @return LanguageInterface
     */
    public static function createLanguage(string $code): LanguageInterface
    {
        if (self::isValidCode($code)) {
            $className = self::CODES_TO_LANGUAGES[$code];
        } else {
            throw new \InvalidArgumentException('Language code '.$code.' not supported');
        }

        return new $className;
    }

    /**
     * @return \Generator|LanguageInterface[]
     */
    public static function allLanguages(): \Generator
    {
        foreach (self::CODES_TO_LANGUAGES as $code => $language) {
            yield self::createLanguage($code);
        }
    }
}
