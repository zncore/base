<?php

namespace ZnCore\Base\Helpers;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface as SymfonyContainerAwareInterface;
use ZnCore\Base\Libs\Container\ContainerAwareInterface;

class DiHelper
{

    public static function make(string $className, ContainerInterface $container = null): object
    {
        if ($container->has($className)) {
            $instance = $container->get($className);
        } else {
            $instance = new $className;
        }
        self::setContainer($instance, $container);
        return $instance;
    }

    public static function setContainer(object $instance, ContainerInterface $container)
    {
        if ($instance instanceof ContainerAwareInterface || $instance instanceof SymfonyContainerAwareInterface) {
            $instance->setContainer($container);
        }
    }

}