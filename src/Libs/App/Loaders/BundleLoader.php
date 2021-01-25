<?php

namespace ZnCore\Base\Libs\App\Loaders;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BaseLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BundleContainerLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BundleI18NextLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ConsoleLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ContainerLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\I18NextLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\MigrationLoader;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\ModuleLoader;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;

class BundleLoader implements LoaderInterface
{

    use ContainerAttributeTrait;

    private $bundles;
//    private $containerConfigLoader;
//    private $containerImportList = [];
    private $import = [];

//    private $mainConfig = [];

    public function __construct(array $bundles, array $import = [])
    {
        $this->bundles = $bundles;
        $this->import = $import;
//        $this->containerConfigLoader = new ContainerConfigLoader();
    }

    public function bootstrapApp(string $appName)
    {

    }

    public function getLoadersConfig()
    {
        return [
            'i18next' => I18NextLoader::class,
            'migration' => MigrationLoader::class,
            'container' => ContainerLoader::class,
            'admin' => ModuleLoader::class,
            'console' => ConsoleLoader::class,
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
//        dd($config);
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
        $configItem = $loaderInstance->loadAll($this->bundles);
        return $configItem;
    }

    /*public function registerBundleMigration(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'migration')) {
            return;
        }
        $i18nextBundles = $bundle->migration();
        $_ENV['ELOQUENT_MIGRATIONS'] = ArrayHelper::merge($_ENV['ELOQUENT_MIGRATIONS'] ?? [], $i18nextBundles);
    }*/

    /*public function registerBundleI18Next(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'i18next')) {
            return;
        }
        $i18nextBundles = $bundle->i18next();
        $_ENV['I18NEXT_BUNDLES'] = ArrayHelper::merge($_ENV['I18NEXT_BUNDLES'] ?? [], $i18nextBundles);
//        $this->mainConfig = ArrayHelper::merge($this->mainConfig, ['i18next' => $i18nextBundles]);

    }*/

    /*public function registerBundleContainer(BaseBundle $bundle, array $config = [])
    {
        if (!method_exists($bundle, 'container')) {
            return;
        }
        $containerConfigList = $bundle->container();
        foreach ($containerConfigList as $containerConfig) {
            $this->mainConfig['container'] = ContainerHelper::importFromConfig([$containerConfig], $this->mainConfig['container'] ?? []);
//            $this->containerImportList[] = $containerConfig;
//                $this->containerConfigLoader->addContainerConfig($containerConfig);
        }
    }*/

    /*public function registerBundleAdmin(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'admin')) {
            return;
        }
        $adminModules = $bundle->admin();
        $this->mainConfig = ArrayHelper::merge($this->mainConfig, $adminModules);
    }*/

    /*public function registerBundleConsole(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'console')) {
            return;
        }
        $consoleCommands = $bundle->console();
        $this->mainConfig = ArrayHelper::merge($this->mainConfig, ['consoleCommands' => $consoleCommands]);
    }*/
}
