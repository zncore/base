<?php

namespace ZnCore\Base\App\Libs;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\App\Loaders\ConfigCollectionLoader;
use ZnCore\Base\Bundle\Libs\BundleLoader;
use ZnCore\Base\ConfigManager\Interfaces\ConfigManagerInterface;
use ZnCore\Base\ConfigManager\Libs\ConfigManager;
use ZnCore\Base\Container\Helpers\ContainerHelper;
use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Container\Libs\ContainerConfigurator;
use ZnCore\Base\Container\Traits\ContainerAwareTrait;
use ZnCore\Base\EventDispatcher\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\EventDispatcher\Libs\EventDispatcherConfigurator;
use ZnCore\Contract\Common\Exceptions\ReadOnlyException;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerConfiguratorInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\EntityManager\Libs\EntityManager;
use ZnCore\Domain\EntityManager\Libs\EntityManagerConfigurator;
use ZnLib\Components\I18Next\Facades\I18Next;

class ZnCore
{

    use ContainerAwareTrait;

    public function init(): ContainerInterface
    {
        $this->initContainer();
        $this->initI18Next();
        $container = $this->getContainer();
        $containerConfigurator = new ContainerConfigurator($container);
        $this->configContainer($containerConfigurator);
        return $container;
    }

    private function initContainer()
    {
        $container = $this->getContainer();
        try {
            ContainerHelper::setContainer($container);
        } catch (ReadOnlyException $exception) {
        }
    }

    public function loadBundles(array $bundles, array $import, string $appName): void
    {
        $bundleLoader = new BundleLoader($bundles, $import);
        $bundleLoader->loadMainConfig($appName);
    }

    private function initI18Next()
    {
        $container = $this->getContainer();
        try {
            I18Next::setContainer($container);
        } catch (ReadOnlyException $exception) {
        }
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(ContainerInterface::class, function () {
            return $this->getContainer();
        });
        $containerConfigurator->singleton(ContainerConfiguratorInterface::class, function () use ($containerConfigurator) {
            return $containerConfigurator;
        });
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
    }
}
