<?php

namespace ZnCore\Base\Helpers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Code\InstanceResolver;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;

class InstanceHelper
{

    public static function create($definition, array $constructParams = [], ContainerInterface $container = null): object
    {
//        return self::ensure($definition, $constructParams, $container);
        return self::getInstanceResolver($container)->create($definition, $constructParams);
    }

    public static function ensure($definition, $constructParams = [], ContainerInterface $container = null): object
    {
        return self::getInstanceResolver($container)->ensure($definition, $constructParams);
    }

    protected static function getInstanceResolver(ContainerInterface $container = null): InstanceResolver
    {
//        $container = $container ?: ContainerHelper::getContainer();
        return new InstanceResolver($container);
    }
}
