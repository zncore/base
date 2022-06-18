<?php

namespace ZnCore\Base\Libs\App\Libs;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Exceptions\ReadOnlyException;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\App\Loaders\ConfigCollectionLoader;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Container\Libs\ContainerConfigurator;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;
use ZnCore\Base\Libs\Event\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\Libs\Event\Libs\EventDispatcherConfigurator;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Interfaces\Libs\EntityManagerConfiguratorInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\EntityManager;
use ZnCore\Domain\Libs\EntityManagerConfigurator;

class ZnCore
{

    use ContainerAwareTrait;

    public function init(): ContainerInterface
    {
        $container = $this->getContainer();
        try {
            ContainerHelper::setContainer($container);
        } catch (ReadOnlyException $exception) {
        }
        try {
            I18Next::setContainer($container);
        } catch (ReadOnlyException $exception) {
        }

        $containerConfigurator = new ContainerConfigurator($container);
        $this->configContainer($containerConfigurator);

        return $container;
    }

    public function loadBundles(array $bundles, array $import, string $appName): void
    {
        $bundleLoader = new BundleLoader($bundles, $import);
        /** @var ConfigCollectionLoader $configCollectionLoader */
        $configCollectionLoader = $this->getContainer()->get(ConfigCollectionLoader::class);
//        $configCollectionLoader->addSubscriber(ConfigureContainerSubscriber::class);
//        $configCollectionLoader->addSubscriber(ConfigureEntityManagerSubscriber::class);
        $configCollectionLoader->setLoader($bundleLoader);
        $config = $configCollectionLoader->loadMainConfig($appName);
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(ContainerInterface::class, function () {
            return $this->getContainer();
        });
        $containerConfigurator->singleton(ContainerConfiguratorInterface::class, function () use ($containerConfigurator) {
            return $containerConfigurator;
        });
//        $containerConfigurator->singleton(EntityManagerInterface::class, EntityManager::class);
        $containerConfigurator->singleton(EntityManagerInterface::class, function (ContainerInterface $container) {
            $em = EntityManager::getInstance($container);
//            $eloquentOrm = $container->get(EloquentOrm::class);
//            $em->addOrm($eloquentOrm);
            return $em;
        });

        $containerConfigurator->singleton(EntityManagerConfiguratorInterface::class, EntityManagerConfigurator::class);

        $containerConfigurator->singleton(EventDispatcherConfiguratorInterface::class, EventDispatcherConfigurator::class);
        $containerConfigurator->singleton(EventDispatcherInterface::class, EventDispatcher::class);
        $containerConfigurator->singleton(\Psr\EventDispatcher\EventDispatcherInterface::class, EventDispatcherInterface::class);
        $containerConfigurator->singleton(ConfigManagerInterface::class, ConfigManager::class);
        $containerConfigurator->singleton(ZnCore::class, function () {
            return $this;
        });
    }
}