<?php

namespace ZnCore\Base\Libs\App\Loaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;

class BundleLoader implements LoaderInterface
{

    private $bundles;
    private $containerConfigLoader;
    private $containerImportList = [];
    private $mainConfig = [];

    public function __construct(array $bundles)
    {
        $this->bundles = $bundles;
        $this->containerConfigLoader = new ContainerConfigLoader();
    }

    public function bootstrapApp(string $appName)
    {

    }

    public function loadMainConfig(string $appName): array
    {
        foreach ($this->bundles as $bundle) {
            $this->registerBundle($bundle);
        }
//        $this->mainConfig['container'] = $this->containerConfigLoader->loadMainConfig('')['container'];
        //dd($this->mainConfig);
        $this->mainConfig['container'] = ContainerHelper::importFromConfig($this->containerImportList);
//        dd($config);
        return $this->mainConfig;
    }

    public function registerBundle(BaseBundle $bundle)
    {
        $import = $bundle->getImportList();
        if (in_array('container', $import)) {
            $containerConfigList = $bundle->container();
            foreach ($containerConfigList as $containerConfig) {
                $this->containerImportList[] = $containerConfig;
//                $this->containerConfigLoader->addContainerConfig($containerConfig);
            }
        }
        if (in_array('admin', $import) && method_exists($bundle, 'admin')) {
            $adminModules = $bundle->admin();
            $this->mainConfig = ArrayHelper::merge($this->mainConfig, $adminModules);
        }
    }
}
