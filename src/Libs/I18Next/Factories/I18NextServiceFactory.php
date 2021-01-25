<?php

namespace ZnCore\Base\Libs\I18Next\Factories;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\Services\TranslationService;

class I18NextServiceFactory
{

    public static function create(string $defaultLanguage, string $language): TranslationServiceInterface

    public static function create(string $defaultLanguage, string $language, array $bundles = []): TranslationServiceInterface
    {
        $translationService = new TranslationService($bundles, $defaultLanguage);
        $translationService->setLanguage($language);
        I18Next::setService($translationService);
        return $translationService;
    }
}
