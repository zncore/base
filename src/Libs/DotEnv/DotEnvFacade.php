<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class DotEnvFacade
{

    const ROOT_PATH = __DIR__ . '/../../../../../..';

    static private $map = [];


    public static function get(string $path = null, $default = null)
    {
        if (empty(self::$map)) {
            self::forgeMap();
        }
        return ArrayHelper::getValue(self::$map, $path, $default);
    }

    private static function forgeMap(): void
    {
        foreach ($_ENV as $name => $value) {
            $pureName = $name;
            $pureName = strtolower($pureName);
            $pureName = str_replace('_', '.', $pureName);
            ArrayHelper::set(self::$map, $pureName, $value);
        }
    }
}