<?php

namespace ZnCore\Base\Helpers;

use ReflectionNamedType;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class InstanceHelper
{

    private static function createObject(string $className, array $constructionArgs = []): object
    {
        $constructionArgs = self::prepareParameters($className, '__construct', $constructionArgs);
        return self::createObjectInstance($className, $constructionArgs);
    }

    public static function callMethod(object $instance, string $methodName, array $parameters = [])
    {
        $parameters = self::prepareParameters(get_class($instance), $methodName, $parameters);
        return call_user_func_array([$instance, $methodName], $parameters);
    }

    public static function create($definition, array $constructParams = []/*, $interfaceClass = null*/): object
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = ClassHelper::normalizeComponentConfig($definition);

        if(empty($constructParams) && array_key_exists('__construct', $definition)) {
            $constructParams = $definition['__construct'];
            unset($definition['__construct']);
        }

        $handlerInstance = self::createObject($definition['class'], $constructParams);
        //$handlerInstance = new $definition['class'];

        /*if ($interfaceClass) {
            ClassHelper::isInstanceOf($handlerInstance, $interfaceClass);
        }*/
        ClassHelper::configure($handlerInstance, $definition);
        return $handlerInstance;
    }

    public static function ensure($definition, $constructParams = []/*, $interfaceClass = null*/): object
    {
        if (is_object($definition)) {
            /*if ($interfaceClass) {
                ClassHelper::isInstanceOf($definition, $interfaceClass);
            }*/
            return $definition;
        }
        return self::create($definition, $constructParams/*, $interfaceClass*/);
    }

    private static function prepareParameters(string $className, string $methodName, array $constructionArgs): array
    {
        if (!ArrayHelper::isIndexed($constructionArgs)) {
            $reflectionClass = new \ReflectionClass($className);
            $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
            $flatParameters = [];
            foreach ($constructorParameters as $index => $constructorParameter) {
                /** @var ReflectionNamedType $parameterType */
                $parameterType = $constructorParameter->getType();
                if($parameterType && array_key_exists($parameterType->getName(), $constructionArgs)) {
                    $parameterName = $parameterType->getName();
                } else {
                    $parameterName = $constructorParameter->name;
                }
                if (array_key_exists($parameterName, $constructionArgs)) {
                    $flatParameters[$index] = $constructionArgs[$parameterName];
                    unset($constructionArgs[$parameterName]);
                }
            }
            foreach ($constructorParameters as $index => $constructorParameter) {
                if(!isset($flatParameters[$index])) {
                    foreach ($constructionArgs as $constructionArgName => $constructionArgValue) {
                        if(is_int($constructionArgName)) {
                            $flatParameters[$index] = $constructionArgValue;
                        }
                    }
                }
            }
            ksort($flatParameters);
            $constructionArgs = $flatParameters;
        }
        return $constructionArgs;
    }

    private static function createObjectInstance(string $className, array $constructionArgs): object
    {
        switch (count($constructionArgs)) {
            case 0:
                $instance = new $className();
                break;
            case 1:
                $instance = new $className(
                    array_shift($constructionArgs)
                );
                break;
            case 2:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            case 3:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            case 4:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            case 5:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            case 6:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            case 7:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            case 8:
                $instance = new $className(
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs),
                    array_shift($constructionArgs)
                );
                break;
            default:
                throw new \Exception('Count parameters not supported!');
        }
        return $instance;
    }

}