<?php

namespace ZnCore\Base\I18Next\Enums;

class LanguageI18nEnum
{

    const LANG_RU = 'ru-RU';
    const LANG_KZ = 'kk-KZ';

    public static function encode(string $locale): string
    {
        $arr = [
            self::LANG_RU => 'ru',
            self::LANG_KZ => 'kz'
        ];
        return $arr[$locale] ?? $locale;
    }
}