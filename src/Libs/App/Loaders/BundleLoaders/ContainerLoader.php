<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;

class ContainerLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $containerConfigList = $this->load($bundle);
            foreach ($containerConfigList as $containerConfig) {
                $config = $this->importFromConfig([$containerConfig], $config);
            }
        }
        return [$this->getName() => $config];
    }

    private function importFromConfig($fileList, array $config = []): array
    {
        foreach ($fileList as $configFile) {
            $toKey = null;
            if (is_array($configFile)) {
                $toKey = $configFile[1];
                $configFile = $configFile[0];
            }
            if ($toKey) {
                $sourceConfig = ArrayHelper::getValue($config, $toKey);
            } else {
                $sourceConfig = $config;
            }
            $requiredConfig = require($configFile);
            $mergedConfig = ArrayHelper::merge($sourceConfig, $requiredConfig);
            ArrayHelper::setValue($config, $toKey, $mergedConfig);
        }
        return $config;
    }
}
