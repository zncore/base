<?php

namespace ZnCore\Base\Libs\Instance\Libs;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\NotImplementedMethodException;
use ZnCore\Base\Libs\Instance\Helpers\ClassHelper;
use ZnCore\Base\Libs\Instance\Helpers\InstanceHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Instance\Libs\Resolvers\InstanceResolver;
use ZnLib\Rpc\Domain\Exceptions\MethodNotFoundException;

class InstanceProvider
{

    private $container;
    private $instanceResolver;

    public function __construct(ContainerInterface $container, InstanceResolver $instanceResolver)
    {
        $this->container = $container;
        $this->instanceResolver = $instanceResolver;
    }

    public function callMethod($definition, array $constructorParameters = [], string $methodName, array $methodParameters)
    {
        $instance = $this->createInstance($definition, $constructorParameters);
        return $this->callMethodOfInstance($instance, $methodName, $methodParameters);
    }

    public function callMethodOfInstance(object $instance, string $methodName, array $methodParameters)
    {
        $this->checkExistsMethod($instance, $methodName);
        return $this->instanceResolver->callMethod($instance, $methodName, $methodParameters);
//        return InstanceHelper::callMethod($instance, $methodName, $methodParameters);
        /*if ($this->container instanceof Container) {
            return $this->container->call([$instance, $methodName], $methodParameters);
        } else {
            return InstanceHelper::callMethod($instance, $methodName, $methodParameters);
//            throw new NotImplementedMethodException('Call method of controller not implemented');
        }*/
    }

    public function createInstance($definition, array $constructorParameters = []): object
    {
        if (is_object($definition)) {
            $instance = $definition;
        } else {
            $definition = ClassHelper::normalizeComponentConfig($definition);
            if(isset($definition['__construct'])) {
                $constructorParameters = ArrayHelper::merge($constructorParameters, $definition['__construct']);
                unset($definition['__construct']);
            }
            $instance = ClassHelper::createInstance($definition, $constructorParameters, $this->container);
            //$instance = $this->container->make($definition, $constructorParameters);
        }
        return $instance;
    }

    private function checkExistsMethod(object $instance, string $methodName): void
    {
        if (!method_exists($instance, $methodName)) {
            $actionName = get_class($instance) . '::' . $methodName;
            throw new MethodNotFoundException('Not found method: ' . $actionName);
        }
    }
}
