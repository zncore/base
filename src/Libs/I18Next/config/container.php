<?php

use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Libs\I18Next\SymfonyTranslation\Translator;

return [
    TranslatorInterface::class => function () {
        return new Translator('symfony');
    },
];

//config i18next bundles
//'symfony' => 'vendor/zncore/base/src/Libs/I18Next/SymfonyTranslation/i18next/__lng__/__ns__.json',
