<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Libs\DotEnv\Libs\DotEnvMap;

class DotEnvFacade
{

    public static function get(string $path = null, $default = null)
    {
        return DotEnvMap::get($path, $default);
    }
}
