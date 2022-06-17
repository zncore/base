<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;

class ContainerLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $containerConfigList = $this->load($bundle);
            foreach ($containerConfigList as $containerConfig) {
                $config = $this->importFromConfig([$containerConfig], $config);
            }
        }
        return [$this->getName() => $config];
    }

    private function importFromConfig($fileList, array $config = []): array
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

            if(is_array($requiredConfig)) {
//                $this->loadFromArray($requiredConfig);

                $mergedConfig = ArrayHelper::merge($sourceConfig, $requiredConfig);
                ArrayHelper::setValue($config, $toKey, $mergedConfig);
            } elseif (is_callable($requiredConfig)) {
                $this->loadFromCallback($requiredConfig);
            }
        }
        return $config;
    }

    private function loadFromArray(array $requiredConfig): void {
        /** @var ContainerConfiguratorInterface $containerConfigurator */
        $containerConfigurator = $this
            ->getContainer()
            ->get(ContainerConfiguratorInterface::class);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this
            ->getContainer()
            ->get(EntityManagerInterface::class);

        if(!empty($requiredConfig['singletons'])) {
            foreach ($requiredConfig['singletons'] as $abstract => $concrete) {
                $containerConfigurator->singleton($abstract, $concrete);
            }
        }

        if(!empty($requiredConfig['definitions'])) {
            foreach ($requiredConfig['definitions'] as $abstract => $concrete) {
                $containerConfigurator->bind($abstract, $concrete);
            }
        }

        if(!empty($requiredConfig['entities'])) {
            foreach ($requiredConfig['entities'] as $entityClass => $repositoryInterface) {
                $entityManager->bindEntity($entityClass, $repositoryInterface);
                if($entityClass == 'App\\Bundles\\User\\Domain\\Entities\\IdentityEntity') {
                    //dump($entityClass, $repositoryInterface);
                }

            }
        }
    }

    private function loadFromCallback(callable $requiredConfig): void {
        $this
            ->getContainer()
            ->call($requiredConfig);
    }
}
