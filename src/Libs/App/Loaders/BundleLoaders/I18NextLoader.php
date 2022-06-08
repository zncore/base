<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use ZnCore\Base\Libs\I18Next\Services\TranslationService;

class I18NextLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $i18nextBundles = $this->load($bundle);
            $config = ArrayHelper::merge($config, $i18nextBundles);
        }
//        $_ENV['I18NEXT_BUNDLES'] = $config;
        $this->getConfigManager()->set('i18nextBundles', $config);
        return [];
//        return [$this->getName() => $config];
    }
}
