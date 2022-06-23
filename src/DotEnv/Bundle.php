<?php

namespace ZnCore\Base\DotEnv;

use ZnCore\Base\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function console(): array
    {
        return [
            __DIR__ . '/../../../../../vendor/symfony/dotenv/Command',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
