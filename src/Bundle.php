<?php

namespace ZnCore\Base;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            'core' => 'vendor/zncore/base/src/i18next/__lng__/__ns__.json',
        ];
    }
}
