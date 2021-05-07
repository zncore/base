<?php

namespace ZnCore\Base\Libs;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\NotImplementedMethodException;
use ZnLib\Rpc\Domain\Exceptions\MethodNotFoundException;

class InstanceProvider
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function callMethod($definition, string $methodName, array $parameters)
    {
        $instance = $this->createInstance($definition);
        return $this->callMethodOfInstance($instance, $methodName, $parameters);
    }

    public function callMethodOfInstance(object $instance, string $methodName, array $parameters)
    {
        $this->checkExistsMethod($instance, $methodName);
        if ($this->container instanceof Container) {
            return $this->container->call([$instance, $methodName], $parameters);
        } else {
            throw new NotImplementedMethodException('Call method of controller not implemented');
        }
    }

    public function createInstance($instance): object
    {
        if (!is_object($instance)) {
            $instance = $this->container->get($instance);
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
