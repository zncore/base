<?php

namespace ZnCore\Base\Libs\I18Next;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            'symfony' => 'vendor/zncore/base/src/Libs/I18Next/SymfonyTranslation/i18next/__lng__/__ns__.json',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/config/new-container.php',
        ];
    }
}
