<?php

namespace ZnCore\Base\Helpers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\ClassNotFoundException;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Libs\Code\InstanceResolver;
use ZnCore\Base\Libs\Code\MethodParametersResolver;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;

class InstanceHelper
{

//    public static function callMethod(object $instance, string $methodName, array $parameters = [], ContainerInterface $container = null)
//    {
//        return self::getInstanceResolver($container)->callMethod($instance, $methodName, $parameters);
//
//        /*$container = $container ?: ContainerHelper::getContainer();
//        $parameters = self::prepareParameters(get_class($instance), $methodName, $parameters, $container);
//        return call_user_func_array([$instance, $methodName], $parameters);*/
//    }

    public static function create($definition, array $constructParams = [], ContainerInterface $container = null): object
    {
        return self::getInstanceResolver($container)->create($definition, $constructParams);

        /*if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = ClassHelper::normalizeComponentConfig($definition);

        if (empty($constructParams) && array_key_exists('__construct', $definition)) {
            $constructParams = $definition['__construct'];
            unset($definition['__construct']);
        }
        $container = $container ?: ContainerHelper::getContainer();
        $handlerInstance = self::createObject($definition['class'], $constructParams, $container);

        ClassHelper::configure($handlerInstance, $definition);
        return $handlerInstance;*/
    }

    public static function ensure($definition, $constructParams = [], ContainerInterface $container = null): object
    {
        return self::getInstanceResolver($container)->ensure($definition, $constructParams);

        /*if (is_object($definition)) {
            return $definition;
        }
        return self::create($definition, $constructParams);*/
    }

    protected static function getInstanceResolver(ContainerInterface $container = null): InstanceResolver
    {
        $container = $container ?: ContainerHelper::getContainer();
        return new InstanceResolver($container);
    }




//    private static function prepareParameters(string $className, string $methodName, array $constructionArgs, ContainerInterface $container = null): array
//    {
//        $container = $container ?: ContainerHelper::getContainer();
//        $methodParametersResolver = new MethodParametersResolver($container);
//        return $methodParametersResolver->resolve($className, $methodName, $constructionArgs);
//
////        return MethodParametersHelper::prepareParameters($className, $methodName, $constructionArgs);
//    }
//
//    /**
//     * @param string $className
//     * @param array $constructionArgs
//     * @return object
//     * @throws ClassNotFoundException
//     */
//    private static function createObject(string $className, array $constructionArgs = [], ContainerInterface $container = null): object
//    {
//        if (!class_exists($className)) {
//            throw new ClassNotFoundException();
//        }
//        $container = $container ?: ContainerHelper::getContainer();
//        $constructionArgs = self::prepareParameters($className, '__construct', $constructionArgs, $container);
//        return self::createObjectInstance($className, $constructionArgs);
//    }
//
//    private static function createObjectInstance(string $className, array $constructionArgs): object
//    {
//        if (count($constructionArgs) && method_exists($className, '__construct')) {
////            $instance = new $className(...$constructionArgs);
//            $instance = (new \ReflectionClass ($className))->newInstanceArgs($constructionArgs);
//        } else {
//            $instance = new $className();
//        }
//        return $instance;
//    }

}
