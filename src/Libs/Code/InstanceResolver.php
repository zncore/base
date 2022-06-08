<?php

namespace ZnCore\Base\Libs\Code;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\ClassNotFoundException;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;

class InstanceResolver
{

    use ContainerAwareTrait;

    public function callMethod(object $instance, string $methodName, array $parameters = [], ContainerInterface $container = null)
    {
        $container = $this->ensureContainer($container);
        $parameters = $this->prepareParameters(get_class($instance), $methodName, $parameters, $container);
        return call_user_func_array([$instance, $methodName], $parameters);
    }

    public function create($definition, array $constructParams = [], ContainerInterface $container = null): object
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = ClassHelper::normalizeComponentConfig($definition);

        if (empty($constructParams) && array_key_exists('__construct', $definition)) {
            $constructParams = $definition['__construct'];
            unset($definition['__construct']);
        }
        $container = $this->ensureContainer($container);
        $handlerInstance = $this->createObject($definition['class'], $constructParams, $container);

        ClassHelper::configure($handlerInstance, $definition);
        return $handlerInstance;
    }

    public function ensure($definition, $constructParams = [], ContainerInterface $container = null): object
    {
        if (is_object($definition)) {
            return $definition;
        }
        $container = $this->ensureContainer($container);
        return $this->create($definition, $constructParams, $container);
    }

    private function prepareParameters(string $className, string $methodName, array $constructionArgs, ContainerInterface $container = null): array
    {
        $container = $this->ensureContainer($container);
        $methodParametersResolver = new MethodParametersResolver($container, $this);
        return $methodParametersResolver->resolve($className, $methodName, $constructionArgs);
    }

    /**
     * @param string $className
     * @param array $constructionArgs
     * @return object
     * @throws ClassNotFoundException
     */
    private function createObject(string $className, array $constructionArgs = [], ContainerInterface $container = null): object
    {
        if (!class_exists($className)) {
            throw new ClassNotFoundException();
        }

        $container = $this->ensureContainer($container);
        $constructionArgs = $this->prepareParameters($className, '__construct', $constructionArgs, $container);
        return $this->createObjectInstance($className, $constructionArgs);
    }

    private function createObjectInstance(string $className, array $constructionArgs): object
    {
        if (count($constructionArgs) && method_exists($className, '__construct')) {
//            $instance = new $className(...$constructionArgs);
            $reflectionClass = new \ReflectionClass($className);
            $instance = $reflectionClass->newInstanceArgs($constructionArgs);
        } else {
            $instance = new $className();
        }
        return $instance;
    }
}
