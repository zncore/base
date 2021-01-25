<?php

use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Libs\I18Next\Factories\I18NextServiceFactory;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\SymfonyTranslation\Translator;

//$translationService = new TranslationService([], Yii::$app->language);
$translationService = I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);

return [
    /*TranslationServiceInterface::class => function() {
        return I18NextServiceFactory::create('ru', 'ru', $_ENV['I18NEXT_BUNDLES'] ?? []);
    },*/
    TranslationServiceInterface::class => $translationService,
    TranslatorInterface::class => function () {
        return new Translator('symfony');
    },
];

//config i18next bundles
//'symfony' => 'vendor/zncore/base/src/Libs/I18Next/SymfonyTranslation/i18next/__lng__/__ns__.json',
