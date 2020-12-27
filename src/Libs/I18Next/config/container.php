<?php

use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Libs\I18Next\SymfonyTranslation\Translator;

return [
    TranslatorInterface::class => function () {
        return new Translator('symfony');
    },
];
