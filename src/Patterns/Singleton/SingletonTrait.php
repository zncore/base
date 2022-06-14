<?php

namespace ZnCore\Base\Patterns\Singleton;

trait SingletonTrait
{

    /**
     * @var static[]|array
     */
    private static $instances = [];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        $className = static::class;
        $isNotFound = !isset(self::$instances[$className]);
        if ($isNotFound) {
            self::$instances[$className] = self::createInstance();
        }
        return self::$instances[$className];
    }

    protected function createInstance(string $className = null): self
    {
        $className = $className ?: static::class;
        return new $className;
    }
}
