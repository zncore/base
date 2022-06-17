<?php

namespace ZnCore\Base\Patterns\Singleton;

trait SingletonTrait
{

    /**
     * @var static[]|array
     */
    private static $instance;

    /*private function __construct()
    {
    }*/

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = self::createInstance();
        }
        return self::$instance;
    }

    private function createInstance(string $className = null): self
    {
        $className = $className ?: static::class;
        return new $className();
    }
}
