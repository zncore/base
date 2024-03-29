<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;

class SymfonyRpcRoutesLoader extends BaseLoader
{

    public function __construct(ConfigManagerInterface $configManager)
    {
        $this->setConfigManager($configManager);
    }

    public function loadAll(array $bundles): array
    {
        $config = [];
        foreach ($bundles as $bundle) {
            $loadedConfig = $this->load($bundle);
            $config = ArrayHelper::merge($config, $loadedConfig);
        }
        $_ENV['RPC_ROUTES'] = $config;
        $this->getConfigManager()->set('rpcRoutes', $config);
        return [];
//        return $config ? ['rpcRoutes' => $config] : [];
    }
}
