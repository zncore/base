<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Libs\App\Helpers\ContainerHelper;

class ContainerLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $containerConfigList = $this->load($bundle);
            foreach ($containerConfigList as $containerConfig) {
                $config = ContainerHelper::importFromConfig([$containerConfig], $config);
            }
        }
        return [$this->getName() => $config];
    }
}
