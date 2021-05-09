<?php

namespace ZnCore\Base\Libs\App\Loaders;

use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BaseLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BundleContainerLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BundleI18NextLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ConsoleLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ContainerLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\I18NextLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\MigrationLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ModuleLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\SymfonyRoutesLoader;
use ZnCore\Base\Libs\Cache\CacheAwareTrait;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;

class BundleLoader implements LoaderInterface
{

    use ContainerAttributeTrait;
    use CacheAwareTrait;

    private $bundles;
    private $import = [];

    public function __construct(array $bundles = [], array $import = [])
    {
        $this->bundles = $bundles;
        $this->import = $import;
    }

    public function addBundles(array $bundles) {
        $this->bundles = ArrayHelper::merge($this->bundles, $bundles);
    }

    public function bootstrapApp(string $appName)
    {

    }

    private $loadersConfig = [
        'migration' => MigrationLoader::class,
        'container' => [
            'class' => ContainerLoader::class,
            //'useCache' => true,
        ],
        'yiiAdmin' => ModuleLoader::class,
        'yiiWeb' => ModuleLoader::class,
        'symfonyWeb' => [
            'class' => SymfonyRoutesLoader::class,
            //'useCache' => true,
        ],
        'console' => ConsoleLoader::class,
        'i18next' => [
            'class' => I18NextLoader::class,
            //'useCache' => true,
        ],
    ];
    
    public function getLoadersConfig()
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
        $loaderInstance->setContainer($this->getContainer());
        if ($this->getCache()) {
            $loaderInstance->setCache($this->getCache());
        }
        if ($loaderInstance->getName() == null) {
            $loaderInstance->setName($loaderName);
        }
        $bundles = $this->filterBundlesByLoader($this->bundles, $loaderName);
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
