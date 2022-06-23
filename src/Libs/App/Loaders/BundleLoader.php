<?php

namespace ZnCore\Base\Libs\App\Loaders;

use ZnCore\Base\Exceptions\ClassNotFoundException;
use ZnCore\Base\Libs\Instance\Helpers\ClassHelper;
use ZnCore\Base\Libs\Instance\Helpers\InstanceHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\ConfigManager\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BaseLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ModuleLoader;
use ZnCore\Base\Libs\Container\Traits\ContainerAttributeTrait;

class BundleLoader implements LoaderInterface
{

    //use ContainerAttributeTrait;

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
            try {
                $bundleInstance = $this->createBundleInstance($bundleDefinition);
                $bundleClass = get_class($bundleInstance);
                if (!isset($this->bundles[$bundleClass])) {
                    if ($bundleInstance->deps()) {
                        $this->addBundles($bundleInstance->deps());
                    }
                    $this->bundles[$bundleClass] = $bundleInstance;
                }
            } catch (ClassNotFoundException $e) {
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

    public function loadMainConfig(string $appName): array
    {
        $loaders = $this->getLoadersConfig();
        $loaders = ArrayHelper::extractByKeys($loaders, $this->import);
        $config = [];
        foreach ($loaders as $loaderName => $loaderDefinition) {
            $configItem = $this->load($loaderName, $loaderDefinition);
            if ($configItem) {
                $config = ArrayHelper::merge($config, $configItem);
            }
        }
        return $config;
    }

    private function load(string $loaderName, $loaderDefinition): array
    {
        /** @var BaseLoader $loaderInstance */
        $loaderInstance = ClassHelper::createObject($loaderDefinition);
        if ($loaderInstance->getName() == null) {
            $loaderInstance->setName($loaderName);
        }
        $bundles = $this->filterBundlesByLoader($this->bundles, $loaderName);
        /*if ($this->getContainer()->has(ConfigManagerInterface::class)) {
            $configManager = $this->getContainer()->get(ConfigManagerInterface::class);
            $configManager->set('bundles', $bundles);
        }*/
        $configItem = $loaderInstance->loadAll($bundles);
        return $configItem;
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
