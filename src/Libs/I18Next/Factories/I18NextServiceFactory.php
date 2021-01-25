<?php

namespace ZnCore\Base\Libs\I18Next\Factories;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\Services\TranslationService;
use ZnCore\Base\Libs\Store\StoreFile;

class I18NextServiceFactory
{

    public static function create(string $defaultLanguage, string $language, array $bundles = []): TranslationServiceInterface
    {
//        $store = new StoreFile($_ENV['I18NEXT_CONFIG_FILE']);
//        $config = $store->load();
//        $defaultLanguage = $defaultLanguage ?? ($config['defaultLanguage'] ?? 'en');
        $defaultLanguage = substr($defaultLanguage, 0, 2);
        $translationService = new TranslationService($bundles, $defaultLanguage);
        $translationService->setLanguage($language);
        I18Next::setService($translationService);
        return $translationService;
    }
}
