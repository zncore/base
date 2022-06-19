<?php

namespace ZnCore\Base\Libs\I18Next\Libs\BundleLoaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Loaders\BundleLoaders\BaseLoader;

class I18NextLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $i18nextBundles = $this->load($bundle);
            $config = ArrayHelper::merge($config, $i18nextBundles);
        }
        $this->getConfigManager()->set('i18nextBundles', $config);
        return [];
    }
}
