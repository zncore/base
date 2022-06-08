<?php

namespace ZnCore\Base\Helpers;

use ReflectionNamedType;
use ZnCore\Base\Exceptions\ClassNotFoundException;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;

class InstanceHelper
{

    public static function callMethod(object $instance, string $methodName, array $parameters = [])
    {
        $parameters = self::prepareParameters(get_class($instance), $methodName, $parameters);
        return call_user_func_array([$instance, $methodName], $parameters);
    }

    public static function create($definition, array $constructParams = []): object
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = ClassHelper::normalizeComponentConfig($definition);

        if (empty($constructParams) && array_key_exists('__construct', $definition)) {
            $constructParams = $definition['__construct'];
            unset($definition['__construct']);
        }

        $handlerInstance = self::createObject($definition['class'], $constructParams);

        ClassHelper::configure($handlerInstance, $definition);
        return $handlerInstance;
    }

    public static function ensure($definition, $constructParams = []): object
    {
        if (is_object($definition)) {
            return $definition;
        }
        return self::create($definition, $constructParams);
    }

    private static function prepareParameters(string $className, string $methodName, array $constructionArgs): array
    {
        if (!ArrayHelper::isIndexed($constructionArgs)) {
            $reflectionClass = new \ReflectionClass($className);
            try {
                $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
                $flatParameters = [];
                foreach ($constructorParameters as $index => $constructorParameter) {
                    /** @var ReflectionNamedType $parameterType */
                    $parameterType = $constructorParameter->getType();
                    if ($parameterType && array_key_exists($parameterType->getName(), $constructionArgs)) {
                        $parameterName = $parameterType->getName();
                    } else {
                        $parameterName = $constructorParameter->name;
                    }
                    if (array_key_exists($parameterName, $constructionArgs)) {
                        $flatParameters[$index] = $constructionArgs[$parameterName];
                        unset($constructionArgs[$parameterName]);
                    } else {
                        if(!$constructorParameter->getType()->allowsNull()) {
                            try {
                                $flatParameters[$index] = ContainerHelper::getContainer()->get($constructorParameter->getType()->getName());
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
                foreach ($constructorParameters as $index => $constructorParameter) {
                    if (!isset($flatParameters[$index])) {
                        foreach ($constructionArgs as $constructionArgName => $constructionArgValue) {
                            if (is_int($constructionArgName)) {
                                $flatParameters[$index] = $constructionArgValue;
                            }
                        }
                    }
                }
                ksort($flatParameters);
                $constructionArgs = $flatParameters;
            } catch (\ReflectionException $e) {
            }
        }
        return $constructionArgs;
    }

    /**
     * @param string $className
     * @param array $constructionArgs
     * @return object
     * @throws ClassNotFoundException
     */
    private static function createObject(string $className, array $constructionArgs = []): object
    {
        if (!class_exists($className)) {
            throw new ClassNotFoundException();
        }
        $constructionArgs = self::prepareParameters($className, '__construct', $constructionArgs);
        return self::createObjectInstance($className, $constructionArgs);
    }

    private static function createObjectInstance(string $className, array $constructionArgs): object
    {
        if (count($constructionArgs) && method_exists($className, '__construct')) {
//            $instance = new $className(...$constructionArgs);
            $instance = (new \ReflectionClass ($className))->newInstanceArgs($constructionArgs);
        } else {
            $instance = new $className();
        }
        return $instance;
    }
}
