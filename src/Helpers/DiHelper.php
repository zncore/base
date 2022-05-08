<?php

namespace ZnCore\Base\Helpers;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface as SymfonyContainerAwareInterface;
use ZnCore\Base\Libs\Container\Interfaces\ContainerAwareInterface;

DeprecateHelper::hardThrow();

class DiHelper
{

    /**
     * Создать объект
     *
     * Пример: $widget = DiHelper::make($widgetClass, $this->container);
     *
     * @param string $className
     * @param ContainerInterface $container
     * @return object
     */
    public static function make(string $className, ContainerInterface $container): object
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