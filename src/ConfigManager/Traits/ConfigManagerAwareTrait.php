<?php

namespace ZnCore\Base\ConfigManager\Traits;

use ZnCore\Base\ConfigManager\Interfaces\ConfigManagerInterface;

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
