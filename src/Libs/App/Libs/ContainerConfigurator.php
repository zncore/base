<?php

namespace ZnCore\Base\Libs\App\Libs;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Helpers\InstanceHelper;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\App\Libs\ContainerConfigurators\IlluminateContainerConfigurator;

class ContainerConfigurator implements ContainerConfiguratorInterface
{

    private $drivers = [
        Container::class => [
            'class' => IlluminateContainerConfigurator::class,
        ]
    ];
    /** @var Container */
    private $container;
    private $configurator;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->configurator = $this->getContainerConfiguratorByContainer($container);
    }

    public function singleton($abstract, $concrete): void
    {
        $this->configurator->singleton($abstract, $concrete);
    }

    public function bind($abstract, $concrete, bool $shared = false): void
    {
        $this->configurator->bind($abstract, $concrete, $shared);
    }

    public function bindContainerSingleton(): void
    {
        $this->configurator->singleton(ContainerConfiguratorInterface::class, function () {
            return $this->container;
        });
        $this->configurator->bindContainerSingleton();
    }

    public function alias($abstract, $alias): void
    {
        $this->configurator->alias($abstract, $alias);
    }

    private function getContainerConfiguratorByContainer(ContainerInterface $container): ContainerConfiguratorInterface
    {
        /** @var ContainerConfiguratorInterface $configurator */
        foreach ($this->drivers as $containerClass => $configuratorDefinition) {
            if ($container instanceof $containerClass) {
                $configurator = InstanceHelper::create($configuratorDefinition['class'], [ContainerInterface::class => $container]);
                //return new $configuratorDefinition($container);
            }
        }
        if (!isset($configurator)) {
            throw new NotFoundException('Not found driver for ContainerConfigurator');
        }
        return $configurator;
    }
}
