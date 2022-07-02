<?php

namespace ZnCore\Base\Container\Helpers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Container\Libs\ContainerConfigurator;
use ZnCore\Base\Container\Traits\ContainerAwareStaticAttributeTrait;

class ContainerHelper
{

    use ContainerAwareStaticAttributeTrait;

    public static function getContainerConfiguratorByContainer(ContainerInterface $container): ContainerConfiguratorInterface
    {
        return new ContainerConfigurator($container);
    }
}
