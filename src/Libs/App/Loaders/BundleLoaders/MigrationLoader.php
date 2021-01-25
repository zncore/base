<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class MigrationLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $i18nextBundles = $this->load($bundle);
            $config = ArrayHelper::merge($config, $i18nextBundles);
        }
        $_ENV['ELOQUENT_MIGRATIONS'] = $config;
        return [];
//        return [$this->getName() => $config];
    }
}
