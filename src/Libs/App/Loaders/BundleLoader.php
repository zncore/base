<?php

namespace ZnCore\Base\Libs\App\Loaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;

class BundleLoader implements LoaderInterface
{

    private $bundles;
//    private $containerConfigLoader;
    private $containerImportList = [];
    private $import = [];
    private $mainConfig = [];

    public function __construct(array $bundles, array $import = [])
    {
        $this->bundles = $bundles;
        $this->import = $import;
//        $this->containerConfigLoader = new ContainerConfigLoader();
    }

    public function bootstrapApp(string $appName)
    {

    }

    public function loadMainConfig(string $appName): array
    {
        if (in_array('migration', $this->import)) {
            foreach ($this->bundles as $bundle) {
                $this->registerBundleMigration($bundle);
            }
        }
        if (in_array('i18next', $this->import)) {
            foreach ($this->bundles as $bundle) {
                $this->registerBundleI18Next($bundle);
            }
        }
        if (in_array('container', $this->import)) {
            foreach ($this->bundles as $bundle) {
                $this->registerBundleContainer($bundle);
            }
        }
        if (in_array('admin', $this->import)) {
            foreach ($this->bundles as $bundle) {
                $this->registerBundleAdmin($bundle);
            }
        }
        if (in_array('console', $this->import)) {
            foreach ($this->bundles as $bundle) {
                $this->registerBundleConsole($bundle);
            }
        }

//        $this->mainConfig['container'] = $this->containerConfigLoader->loadMainConfig('')['container'];
        $this->mainConfig['container'] = ContainerHelper::importFromConfig($this->containerImportList);
        return $this->mainConfig;
    }

    public function registerBundleMigration(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'migration')) {
            return;
        }
        $i18nextBundles = $bundle->migration();
        $_ENV['ELOQUENT_MIGRATIONS'] = ArrayHelper::merge($_ENV['ELOQUENT_MIGRATIONS'] ?? [], $i18nextBundles);
    }

    public function registerBundleI18Next(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'i18next')) {
            return;
        }
        $i18nextBundles = $bundle->i18next();
        $_ENV['I18NEXT_BUNDLES'] = ArrayHelper::merge($_ENV['I18NEXT_BUNDLES'] ?? [], $i18nextBundles);
//        $this->mainConfig = ArrayHelper::merge($this->mainConfig, ['i18next' => $i18nextBundles]);

    }

    public function registerBundleContainer(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'container')) {
            return;
        }
        $containerConfigList = $bundle->container();
        foreach ($containerConfigList as $containerConfig) {
            $this->containerImportList[] = $containerConfig;
//                $this->containerConfigLoader->addContainerConfig($containerConfig);
        }
    }

    public function registerBundleAdmin(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'admin')) {
            return;
        }
        $adminModules = $bundle->admin();
        $this->mainConfig = ArrayHelper::merge($this->mainConfig, $adminModules);
    }

    public function registerBundleConsole(BaseBundle $bundle)
    {
        if (!method_exists($bundle, 'console')) {
            return;
        }
        $consoleCommands = $bundle->console();
        $this->mainConfig = ArrayHelper::merge($this->mainConfig, ['consoleCommands' => $consoleCommands]);
    }
}
