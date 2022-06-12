<?php

namespace ZnCore\Base\Helpers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Code\InstanceResolver;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;

/**
 * Работа с объектами
 */
class InstanceHelper
{

    /**
     * Создать класс
     * @param $definition
     * @param array $constructParams
     * @param ContainerInterface|null $container
     * @return object
     * @throws \ZnCore\Base\Exceptions\InvalidConfigException
     */
    public static function create($definition, array $constructParams = [], ContainerInterface $container = null): object
    {
//        return self::ensure($definition, $constructParams, $container);
        return self::getInstanceResolver($container)->create($definition, $constructParams);
    }

    /**
     * Обеспечить класс
     * Если придет объект в определении класса, то он его вернет, иначе создаст новый класс.
     * @param $definition
     * @param array $constructParams
     * @param ContainerInterface|null $container
     * @return object
     */
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
