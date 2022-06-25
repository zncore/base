<?php

namespace ZnCore\Base\SymfonyTranslation;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            'symfony' => 'vendor/zncore/base/src/SymfonyTranslation/i18next/__lng__/__ns__.json',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/config/container.php',
        ];
    }
}