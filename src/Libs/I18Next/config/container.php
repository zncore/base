<?php

use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Libs\I18Next\Factories\I18NextServiceFactory;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\SymfonyTranslation\Translator;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\I18Next\Services\TranslationService;

//$translationService = new TranslationService([], Yii::$app->language);
//$translationService = I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);

return [
    /*TranslationServiceInterface::class => function() {
        return I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);
    },*/
    TranslationServiceInterface::class => TranslationService::class,
    TranslationService::class => function (ContainerInterface $container) {
        return I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);
    },
    TranslatorInterface::class => function (ContainerInterface $container) {
        return $container->make(Translator::class, [
            'locale' => 'ru',
            'bundleName' => 'symfony',
        ]);
        //return new Translator('ru', 'symfony');
    },
];

//config i18next bundles
//'symfony' => 'vendor/zncore/base/src/Libs/I18Next/SymfonyTranslation/i18next/__lng__/__ns__.json',
