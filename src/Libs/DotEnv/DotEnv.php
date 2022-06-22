<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Libs\DotEnv\Enums\DotEnvModeEnum;
use ZnCore\Base\Libs\DotEnv\Libs\DotEnvBootstrap;

class DotEnv
{

    public static function init(string $mode = DotEnvModeEnum::MAIN, string $basePath = null): void
    {
        DotEnvBootstrap::load($mode, $basePath);
    }

    public static function get(string $name = null, $default = null)
    {
        $name = mb_strtoupper($name);
        return $_ENV[$name] ?? $default;
    }
}
