<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Exceptions\NotInstanceOfException;
use ZnCore\Base\Interfaces\GetLabelsInterface;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;

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
        if (!self::isValid($className, $value, $prefix)) {
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
        if (!empty($prefix)) {
            $constants = ReflectionHelper::getConstantsByPrefix($className, $prefix);
        } else {
            $constants = ReflectionHelper::getConstants($className);
        }
        return $constants;
    }

    public static function getLabel(string $className, $constValue): string
    {
        $labels = self::getLabels($className);
        return $labels[$constValue];
    }

    public static function getLabels(string $className): array
    {
        /** @var GetLabelsInterface $className */
        ClassHelper::isInstanceOf($className, GetLabelsInterface::class, true);
        $labels = $className::getLabels();
        return $labels;
    }

    public static function getLabelsForce(string $className, array $all = null): array
    {
        try {
            $labels = EnumHelper::getLabels($className);
        } catch (NotInstanceOfException $e) {
            $labels = null;
        }
        if(empty($labels)) {
            $all = $all ?: EnumHelper::all($className);
            $labels = array_flip($all);
            $labels = array_map(function ($value) {
                $value = strtolower($value);
                return Inflector::titleize($value);
            }, $labels);
        }
        return $labels;
    }

    public static function getItems(string $className): array
    {
        $all = EnumHelper::all($className);
        $labels = self::getLabelsForce($className, $all);
        $items = [];
        foreach ($all as $name => $id) {
            $items[] = [
                'id' => $id,
                'name' => mb_strtolower($name),
                'title' => $labels[$id],
            ];
        }
        return $items;
    }
}
