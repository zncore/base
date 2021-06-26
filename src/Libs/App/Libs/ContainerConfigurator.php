<?php

namespace ZnCore\Base\Libs\App\Libs;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\App\Libs\ContainerConfigurators\IlluminateContainerConfigurator;

class ContainerConfigurator implements ContainerConfiguratorInterface
{

    private $drivers = [
        Container::class => IlluminateContainerConfigurator::class,
    ];
    /** @var Container */
    private $container;
    private $configurator;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->configurator = $this->getContainerConfiguratorByContainer($container);
    }

    public function getContainerConfiguratorByContainer(ContainerInterface $container): ContainerConfiguratorInterface
    {
        /*if($container instanceof Container) {
            $configurator = new IlluminateContainerConfigurator($container);
        }*/
        foreach ($this->drivers as $containerClass => $configuratorClass) {
            if ($container instanceof $containerClass) {
                /** @var ContainerConfiguratorInterface $configurator */
//                $configurator = $container->make($configuratorClass);
                //dd($configuratorClass);
                $configurator = new $configuratorClass($container);
//                $configurator = ClassHelper::createInstance($configuratorClass, [], $container);
            }
        }
        //dd($configurator);
        /*if ($container instanceof Container) {
            $configurator = new IlluminateContainerConfigurator($container);
//            $container->singleton(ContainerConfiguratorInterface::class, IlluminateContainerConfigurator::class);
        }*/
        return $configurator;
    }

    public function singleton($abstract, $concrete): void
    {
        $this->configurator->singleton($abstract, $concrete);
    }

    public function bind($abstract, $concrete, bool $shared = false): void
    {
        $this->configurator->bind($abstract, $concrete, $shared);
    }
}
