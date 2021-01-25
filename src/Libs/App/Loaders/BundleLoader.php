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
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;

class BundleLoader implements LoaderInterface
{

    use ContainerAttributeTrait;

    private $bundles;
    private $import = [];

    public function __construct(array $bundles, array $import = [])
    {
        $this->bundles = $bundles;
        $this->import = $import;
    }

    public function bootstrapApp(string $appName)
    {

    }

    public function getLoadersConfig()
    {
        return [
            'migration' => MigrationLoader::class,
            'container' => ContainerLoader::class,
            'admin' => ModuleLoader::class,
            'symfonyWeb' => SymfonyRoutesLoader::class,
            'console' => ConsoleLoader::class,
            'i18next' => I18NextLoader::class,
        ];
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
            if (in_array($loaderName, $importList)) {
                $resultBundles[] = $bundle;
            }
        }
        return $resultBundles;
    }
}
