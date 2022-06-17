<?php

use Psr\Container\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\Services\TranslationService;
use ZnCore\Base\Libs\I18Next\SymfonyTranslation\Translator;

//$translationService = new TranslationService([], Yii::$app->language);
//$translationService = I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);

$defaultLang = 'ru';

return [
    'singletons' => [
        /*TranslationServiceInterface::class => function() {
            return I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);
        },*/
        TranslationServiceInterface::class => function (ContainerInterface $container) use($defaultLang) {
            /** @var TranslationServiceInterface $translationService */
            $translationService = $container->get(TranslationService::class);
            $translationService->setLanguage($defaultLang);

            /** @var \ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface $configManager */
            $configManager = $container->get(\ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface::class);
            $bundleConfig = $configManager->get('i18nextBundles', []);

            $translationService->setBundles($bundleConfig);
            $translationService->setDefaultLanguage($defaultLang);
//            \ZnCore\Base\Libs\I18Next\Facades\I18Next::setService($translationService);
            return $translationService;
            //return I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);
        },
        TranslatorInterface::class => function (ContainerInterface $container) use($defaultLang) {
            return $container->make(Translator::class, [
                'locale' => 'ru',
                'bundleName' => 'symfony',
            ]);
            //return new Translator('ru', 'symfony');
        },
    ],
];

//config i18next bundles
//'symfony' => 'vendor/zncore/base/src/Libs/I18Next/SymfonyTranslation/i18next/__lng__/__ns__.json',
