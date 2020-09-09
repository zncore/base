<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Exceptions\InvalidConfigException;

class InstanceHelper
{

    public static function create($definition, array $constructParams = [], $interfaceClass = null): object
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = ClassHelper::normalizeComponentConfig($definition);
        $handlerInstance = new $definition['class'];
        if ($interfaceClass) {
            ClassHelper::isInstanceOf($handlerInstance, $interfaceClass);
        }
        ClassHelper::configure($handlerInstance, $definition);
        return $handlerInstance;
    }

    public static function ensure($definition, $constructParams = [], $interfaceClass = null): object
    {
        if (is_object($definition)) {
            if ($interfaceClass) {
                ClassHelper::isInstanceOf($definition, $interfaceClass);
            }
            return $definition;
        }
        return self::create($definition, $constructParams, $interfaceClass);
    }

}