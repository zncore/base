<?php

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\EventDispatcher\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\EventDispatcher\Libs\EventDispatcherConfigurator;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerConfiguratorInterface;

return function (ContainerConfiguratorInterface $containerConfigurator) {
    $containerConfigurator->singleton(EventDispatcherConfiguratorInterface::class, EventDispatcherConfigurator::class);
    $containerConfigurator->singleton(EventDispatcherInterface::class, EventDispatcher::class);
    $containerConfigurator->singleton(\Psr\EventDispatcher\EventDispatcherInterface::class, EventDispatcherInterface::class);
};
