<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

DeprecateHelper::hardThrow();

class ModuleLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $loadedConfig = $this->load($bundle);
            $config = ArrayHelper::merge($config, $loadedConfig);
        }
        return $config;
    }
}
