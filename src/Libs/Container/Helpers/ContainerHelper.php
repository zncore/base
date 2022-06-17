<?php

namespace ZnCore\Base\Libs\Container\Helpers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\ReadOnlyException;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Container\Libs\ContainerConfigurator;

class ContainerHelper
{

    private static $container = null;

    public static function setContainer(ContainerInterface $container): void
    {
        if (self::$container) {
            throw new ReadOnlyException();
        }
        self::$container = $container;
    }

    /**
     * @return ContainerInterface|null
     */
    public static function getContainer(): ?ContainerInterface
    {
        return self::$container;
    }

    public static function getContainerConfiguratorByContainer(ContainerInterface $container): ContainerConfiguratorInterface
    {
        return new ContainerConfigurator($container);
    }

    public static function configureContainer(ContainerInterface $container, array $containerConfig)
    {
        DeprecateHelper::hardThrow();
        $configurator = self::getContainerConfiguratorByContainer($container);
        $configurator->bindContainerSingleton();
        self::configContainerFromArray($configurator, $containerConfig);
    }

    public static function configContainerFromArray(ContainerConfiguratorInterface $containerConfigurator, array $containerConfig): void
    {
        DeprecateHelper::hardThrow();
        if (isset($containerConfig['definitions'])) {
            foreach ($containerConfig['definitions'] as $abstract => $concrete) {
                $containerConfigurator->bind($abstract, $concrete, true);
            }
        }
        if (isset($containerConfig['singletons'])) {
            foreach ($containerConfig['singletons'] as $abstract => $concrete) {
                if (is_integer($abstract)) {
                    $abstract = $concrete;
                }
                $containerConfigurator->singleton($abstract, $concrete);
            }
        }
    }
}
