<?php

namespace ZnCore\Base\DotEnv\Domain\Libs;

use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\Patterns\Singleton\SingletonTrait;

class DotEnvMap
{

    use SingletonTrait;

    private $map = [];

    private function __construct()
    {
        $this->forgeMap();
    }

    public static function get(string $path = null, $default = null) {
        return self::getInstance()->getValue($path, $default);
    }

    public function getValue(string $path = null, $default = null)
    {
        return ArrayHelper::getValue($this->map, $path, $default);
    }

    private function forgeMap(): void
    {
        foreach ($_ENV as $name => $value) {
            $pureName = $this->prepareName($name);
            ArrayHelper::set($this->map, $pureName, $value);
        }
    }

    private function prepareName(string $name): string
    {
        $name = strtolower($name);
        $name = str_replace('_', '.', $name);
        return $name;
    }
}
