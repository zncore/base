<?php

namespace ZnCore\Base\App\Loaders;

use ZnCore\Base\App\Base\BaseBundle;
use ZnCore\Base\App\Interfaces\LoaderInterface;
use ZnCore\Base\App\Loaders\BundleLoaders\BaseLoader;
use ZnCore\Base\App\Loaders\BundleLoaders\ModuleLoader;
use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\Instance\Helpers\ClassHelper;
use ZnCore\Base\Instance\Helpers\InstanceHelper;

class BundleLoader implements LoaderInterface
{

    private $bundles = [];
    private $import = [];
    private $loadersConfig = [];

    public function __construct(array $bundles = [], array $import = [])
    {
        $this->addBundles($bundles);
        $this->import = $import;
    }

    private function createBundleInstance($bundleDefinition): BaseBundle
    {
        /** @var BaseBundle $bundleInstance */
        if (is_object($bundleDefinition)) {
            $bundleInstance = $bundleDefinition;
        } elseif (is_string($bundleDefinition)) {
            $bundleInstance = InstanceHelper::create($bundleDefinition, [['all']]);
        } elseif (is_array($bundleDefinition)) {
            $bundleInstance = InstanceHelper::create($bundleDefinition);
        }
        return $bundleInstance;
    }

    public function addBundles(array $bundles)
    {
        foreach ($bundles as $bundleDefinition) {
            $bundleInstance = $this->createBundleInstance($bundleDefinition);
            $bundleClass = get_class($bundleInstance);
            if (!isset($this->bundles[$bundleClass])) {
                if ($bundleInstance->deps()) {
                    $this->addBundles($bundleInstance->deps());
                }
                $this->bundles[$bundleClass] = $bundleInstance;
            }
        }
    }

    private function getLoadersConfig()
    {
        return $this->loadersConfig;
    }

    public function addLoaderConfig(string $name, $loader)
    {
        $this->loadersConfig[$name] = $loader;
    }

    public function loadMainConfig(string $appName): void
    {
        $loaders = $this->getLoadersConfig();
        $loaders = ArrayHelper::extractByKeys($loaders, $this->import);
        foreach ($loaders as $loaderName => $loaderDefinition) {
            $this->load($loaderName, $loaderDefinition);
        }
    }

    private function load(string $loaderName, $loaderDefinition): void
    {
        /** @var BaseLoader $loaderInstance */
        $loaderInstance = ClassHelper::createObject($loaderDefinition);
        if ($loaderInstance->getName() == null) {
            $loaderInstance->setName($loaderName);
        }
        $bundles = $this->filterBundlesByLoader($this->bundles, $loaderName);
        $loaderInstance->loadAll($bundles);
    }

    private function filterBundlesByLoader(array $bundles, string $loaderName): array
    {
        $resultBundles = [];
        foreach ($bundles as $bundle) {
            /** @var BaseBundle $bundle */
            $importList = $bundle->getImportList();
            if (in_array($loaderName, $importList) || in_array('all', $importList)) {
                $resultBundles[] = $bundle;
            }
        }
        return $resultBundles;
    }
}
