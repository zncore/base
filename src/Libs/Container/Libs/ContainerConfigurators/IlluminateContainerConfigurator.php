<?php

namespace ZnCore\Base\Libs\Container\Libs\ContainerConfigurators;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;

class IlluminateContainerConfigurator implements ContainerConfiguratorInterface
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        ClassHelper::checkInstanceOf($container, Container::class);
    }

    public function singleton($abstract, $concrete): void
    {
        $this->container->singleton($abstract, $concrete);
    }

    public function bind($abstract, $concrete, bool $shared = false): void
    {
        $this->container->bind($abstract, $concrete, $shared);
    }

    public function bindContainerSingleton(): void
    {
        $this->container->singleton(ContainerInterface::class, Container::class);
        $this->container->singleton(Container::class, function () {
            return $this->container;
        });
    }

    public function alias($abstract, $alias): void
    {
        $this->container->alias($abstract, $alias);
    }
}
