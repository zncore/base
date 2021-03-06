<?php

namespace ZnCore\Base\Libs\App\Helpers;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class ContainerHelper 
{

    private static $container;

    public static function setContainer(object $container)
    {
        self::$container = $container;
    }

    public static function importFromConfig($fileList, array $config = []): array
    {
        foreach ($fileList as $configFile) {
            $toKey = null;
            if (is_array($configFile)) {
                $toKey = $configFile[1];
                $configFile = $configFile[0];
            }
            if ($toKey) {
                $sourceConfig = ArrayHelper::getValue($config, $toKey);
            } else {
                $sourceConfig = $config;
            }
            $requiredConfig = require($configFile);
            $mergedConfig = ArrayHelper::merge($sourceConfig, $requiredConfig);
            ArrayHelper::setValue($config, $toKey, $mergedConfig);
        }
        return $config;
    }

    public static function mergeFromFiles(array $config, array $fileList, string $toKey = null): array
    {
        foreach ($fileList as $configFile) {
            if($toKey) {
                $sourceConfig = ArrayHelper::getValue($config, $toKey);
            } else {
                $sourceConfig = $config;
            }
            $mergedConfig = ArrayHelper::merge($sourceConfig, require($configFile));
            ArrayHelper::setValue($config, $toKey, $mergedConfig);
        }
        return $config;
    }

    /**
     * @return ContainerInterface|null
     */
    public static function getContainer(): ?object
    {
        if (isset(self::$container)) {
            return self::$container;
        }
        if (class_exists(Container::class)) {
            return Container::getInstance();
        }
        return null;
    }

    public static function configureContainer(ContainerInterface $container, array $containerConfig)
    {
        $container->singleton(ContainerInterface::class, Container::class);
        $container->singleton(Container::class, function () use ($container) {
            return $container;
        });
        if(isset($containerConfig['definitions'])) {
            foreach ($containerConfig['definitions'] as $abstract => $concrete) {
                $container->bind($abstract, $concrete, true);
            }
        }
        if(isset($containerConfig['singletons'])) {
            foreach ($containerConfig['singletons'] as $abstract => $concrete) {
                $container->singleton($abstract, $concrete);
            }
        }
    }
}
