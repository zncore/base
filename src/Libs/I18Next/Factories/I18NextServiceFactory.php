<?php

namespace ZnCore\Base\Libs\I18Next\Factories;

use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\Services\TranslationService;
use ZnCore\Base\Libs\Store\StoreFile;

DeprecateHelper::hardThrow();

class I18NextServiceFactory
{

    public static function create(string $defaultLanguage, string $language, array $bundles = []): TranslationServiceInterface
    {
//        $store = new StoreFile($_ENV['I18NEXT_CONFIG_FILE']);
//        $config = $store->load();
//        $defaultLanguage = $defaultLanguage ?? ($config['defaultLanguage'] ?? 'en');
        $defaultLanguage = substr($defaultLanguage, 0, 2);
        /** @var TranslationServiceInterface $translationService */
//        $translationService = ClassHelper::createObject(TranslationServiceInterface::class);
        $translationService = new TranslationService($bundles, $defaultLanguage);
        $translationService->setLanguage($language);
        $translationService->setBundles($bundles);
        $translationService->setDefaultLanguage($defaultLanguage);
        
        //I18Next::setService($translationService);
        return $translationService;
    }
}
