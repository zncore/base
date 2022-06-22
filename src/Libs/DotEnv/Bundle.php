<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function console(): array
    {
        return [
            __DIR__ . '/../../../../../../vendor/symfony/dotenv/Command',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
