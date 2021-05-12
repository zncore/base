<?php

namespace ZnCore\Base\Libs\App;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function container(): array
    {
        return [
            __DIR__ . '/container.php',
        ];
    }
}
