<?php

namespace ZnCore\Base\Libs\ConfigManager\Traits;

use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;

trait ConfigManagerAwareTrait
{

    private $configManager;

    protected function getConfigManager(): ConfigManagerInterface
    {
        return $this->configManager;
    }

    protected function setConfigManager(ConfigManagerInterface $configManager): void
    {
        $this->configManager = $configManager;
    }
}
