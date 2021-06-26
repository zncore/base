<?php

namespace ZnCore\Base\Libs\App\Libs\ContainerConfigurators;

use Illuminate\Container\Container;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;

class IlluminateContainerConfigurator implements ContainerConfiguratorInterface
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function singleton($abstract, $concrete): void
    {
        $this->container->singleton($abstract, $concrete);
    }

    public function bind($abstract, $concrete, bool $shared = false): void
    {
        $this->container->bind($abstract, $concrete, $shared);
    }
}
