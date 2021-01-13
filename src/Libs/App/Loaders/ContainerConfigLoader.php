<?php

namespace ZnCore\Base\Libs\App\Loaders;

use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;

class ContainerConfigLoader implements LoaderInterface
{
    
    private $mapConfig;
    
    public function __construct(string $mapConfig = null)
    {
        $this->mapConfig = $mapConfig ?: __DIR__ . '/../../../../../../../' . $_ENV['CONTAINER_CONFIG_FILE'];
    }

    public function bootstrapApp(string $appName)
    {
        
    }

    public function loadMainConfig(string $appName): array
    {
        $config['container'] = ContainerHelper::importFromConfig($this->mapConfig);
        return $config;
    }
}
