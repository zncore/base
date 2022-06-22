<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Libs\DotEnv\Libs\DotEnvIniter;

class DotEnv
{

    const ROOT_PATH = __DIR__ . '/../../../../../..';

//    static private $isInited = false;

    public static function init(string $basePath = self::ROOT_PATH, string $mode = 'main'): void
    {
        /*if (self::$isInited) {
            return;
        }
        self::$isInited = true;*/
        DotEnvIniter::getInstance()->init($basePath, $mode);
    }

    public static function get(string $name = null, $default = null)
    {
        $name = mb_strtoupper($name);
        return $_ENV[$name] ?? $default;
    }
}
