<?php

namespace ZnCore\Base\Libs\App\Loaders;

use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;

class ContainerConfigLoader implements LoaderInterface
{

    use ContainerAttributeTrait;

    private $mapConfig;
    
    public function __construct($mapConfig = null)
    {
        if(is_string($mapConfig)) {
            $this->mapConfig = require $mapConfig;
        } elseif(is_array($mapConfig)) {
            $this->mapConfig = $mapConfig;
        }
    }

    public function addContainerConfig($configFile)
    {
        $this->mapConfig[] = $configFile;
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
