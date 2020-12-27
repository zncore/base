<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class EnumHelper
{

    public static function getValues(string $className, $prefix = null): array
    {
        $constants = static::all($className, $prefix);
        $constants = array_values($constants);
        $constants = array_unique($constants);
        return $constants;
    }

    public static function validate(string $className, $value, $prefix = null)
    {
        if ( ! self::isValid($className, $value, $prefix)) {
            $class = static::class;
            throw new InvalidArgumentException("Value \"$value\" not contains in \"$class\" enum");
        }
    }

    public static function isValid(string $className, $value, $prefix = null)
    {
        return in_array($value, static::getValues($className, $prefix));
    }
    
    public static function getValue(string $className, $value, $default = null, $prefix = null)
    {
        if (self::isValid($className, $value, $prefix)) {
            return $value;
        } else {
            if ($default !== null && self::isValid($className, $default, $prefix)) {
                return $default;
            }
            $values = self::getValues($className, $prefix);
            return $values[0];
        }
    }

    public static function all(string $className, $prefix = null): array
    {
        if ( ! empty($prefix)) {
            $constants = ReflectionHelper::getConstantsByPrefix($className, $prefix);
        } else {
            $constants = ReflectionHelper::getConstants($className);
        }
        return $constants;
    }

    public static function getLabel(string $className, $constValue) {
        //ClassHelper::isInstanceOf($className, GetLabelsInterface::class);
        $labels = $className::getLabels();
        return $labels[$constValue];
    }

}
