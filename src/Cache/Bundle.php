<?php

namespace ZnCore\Base\Cache;

use ZnCore\Base\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function container(): array
    {
        return [
            __DIR__ . '/config/container.php',
        ];
    }
}
