<?php

namespace ZnCore\Base\Helpers;

use ReflectionNamedType;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class InstanceHelper
{

    private static function prepareParameters(string $className, string $methodName, array $constructionArgs): array
    {
        if (!ArrayHelper::isIndexed($constructionArgs)) {
            $reflectionClass = new \ReflectionClass($className);
            $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
            $flatParameters = [];
            foreach ($constructorParameters as $constructorParameter) {
                $parameterName = $constructorParameter->name;
                /** @var ReflectionNamedType $parameterType */
                $parameterType = $constructorParameter->getType();
                $parameterTypeName = $parameterType ? $parameterType->getName() : null;
                if (array_key_exists($parameterName, $constructionArgs)) {
                    $flatParameters[] = $constructionArgs[$parameterName];
                } elseif (!empty($parameterTypeName) && array_key_exists($parameterTypeName, $constructionArgs)) {
                    $flatParameters[] = $constructionArgs[$parameterTypeName];
                }
            }
            $constructionArgs = $flatParameters;
        }
        return $constructionArgs;
    }

    private static function createObject(string $className, array $constructionArgs = []): object
    {
        $constructionArgs = self::prepareParameters($className, '__construct', $constructionArgs);
        switch (count($constructionArgs)) {
            case 0:
                $handle = new $className();
                break;
            case 1:
                $handle = new $className(array_shift($constructionArgs));
                break;
            case 2:
                $handle = new $className(array_shift($constructionArgs), array_shift($constructionArgs));
                break;
            case 3:
                $handle = new $className(array_shift($constructionArgs), array_shift($constructionArgs), array_shift($constructionArgs));
                break;
            default:
                // Too many arguments for this cobbled together implemenentation.  :(
                die;
        }
        return $handle;
    }

    public static function callMethod(object $instance, string $methodName, array $parameters = [])
    {
        $parameters = self::prepareParameters(get_class($instance), $methodName, $parameters);
        return call_user_func_array([$instance, $methodName], $parameters);
    }

    public static function create($definition, array $constructParams = [], $interfaceClass = null): object
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = ClassHelper::normalizeComponentConfig($definition);

        $handlerInstance = self::createObject($definition['class'], $constructParams);
        //$handlerInstance = new $definition['class'];

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