<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Cache\CacheInterface;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Libs\ConfigManager;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\EntityManager;
use ZnLib\Db\Capsule\Manager;
use ZnLib\Db\Factories\ManagerFactory;
use ZnLib\Fixture\Domain\Repositories\FileRepository;
use ZnCore\Base\Libs\DotEnv\DotEnvConfig;
use ZnCore\Base\Libs\DotEnv\DotEnvConfigInterface;

return [
    'definitions' => [],
    'singletons' => [
        ContainerInterface::class => function () {
            return \ZnCore\Base\Libs\App\Helpers\ContainerHelper::getContainer();
        },
        EntityManagerInterface::class => function (ContainerInterface $container) {
            $em = EntityManager::getInstance($container);
//            $eloquentOrm = $container->get(EloquentOrm::class);
//            $em->addOrm($eloquentOrm);
            return $em;
        },
        ConfigManagerInterface::class => ConfigManager::class,
        EventDispatcherInterface::class => function () {
            $eventDispatcher = new EventDispatcher();
            return $eventDispatcher;
        },
        FileRepository::class => function () {
            return new FileRepository(DotEnv::get('ELOQUENT_CONFIG_FILE'));
        },
        Manager::class => function () {
            return ManagerFactory::createManagerFromEnv();
        },
        AdapterInterface::class => function (ContainerInterface $container) {
            if (EnvHelper::isTest() || EnvHelper::isDev()) {
                $adapter = new NullAdapter();
            } else {
                $cacheDirectory = __DIR__ . '/../' . DotEnv::get('CACHE_DIRECTORY');
                $adapter = new FilesystemAdapter('app', TimeEnum::SECOND_PER_DAY, $cacheDirectory);
                $adapter->setLogger($container->get(LoggerInterface::class));
            }
            return $adapter;
        },
        //LoggerInterface::class => NullLogger::class,
        //\Symfony\Component\Cache\Adapter\AbstractAdapter::class => AdapterInterface::class,
        CacheInterface::class => AdapterInterface::class,
        DotEnvConfigInterface::class => function() {
            return new DotEnvConfig($_ENV);
        },
    ],
];