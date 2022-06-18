<?php

namespace ZnCore\Base\Libs\App;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function container(): array
    {
        return [
            __DIR__ . '/config/container.php',
            __DIR__ . '/config/container-cache.php',
        ];
    }
}
