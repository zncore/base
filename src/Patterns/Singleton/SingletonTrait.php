<?php

namespace ZnCore\Base\Patterns\Singleton;

trait SingletonTrait implements SingletonInterface
{

    /**
     * @var static[]|array
     */
    private static $instances = [];

    public static function getInstance(): object
    {
        $className = static::class;
        $isNotFound = ! isset(self::$instances[$className]);
        if ($isNotFound) {
            self::$instances[$className] = new $className;
        }
        return self::$instances[$className];
    }

}