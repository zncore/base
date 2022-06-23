<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZnCore\Base\DotEnv\Domain\Libs\DotEnv;
use ZnCore\Base\Env\Helpers\EnvHelper;
use ZnCore\Base\Time\Enums\TimeEnum;

return [
    'singletons' => [
        AdapterInterface::class => function (ContainerInterface $container) {
            if (EnvHelper::isTest() || EnvHelper::isDev()) {
                $adapter = new ArrayAdapter();
            } else {
                $cacheDirectory = __DIR__ . '/../../../../../../' . DotEnv::get('CACHE_DIRECTORY');
                $adapter = new FilesystemAdapter('app', TimeEnum::SECOND_PER_DAY, $cacheDirectory);
                $adapter->setLogger($container->get(LoggerInterface::class));
            }
            return $adapter;
        },

    ],
];
