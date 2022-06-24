<?php

namespace ZnCore\Base\I18Next\Libs\BundleLoaders;

use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\Bundle\Base\BaseLoader;

class I18NextLoader extends BaseLoader
{

    public function loadAll(array $bundles): void
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $i18nextBundles = $this->load($bundle);
            $config = ArrayHelper::merge($config, $i18nextBundles);
        }
        $this->getConfigManager()->set('i18nextBundles', $config);
    }
}
