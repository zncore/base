<?php

namespace ZnCore\Base\Libs\ConfigManager\Libs;

use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;

class ConfigManager implements ConfigManagerInterface
{

    private $config;

    public function set(string $name, $value): void
    {
        $this->config[$name] = $value;
    }

    public function get(string $name, $defaultValue = null)
    {
        return $this->config[$name] ?? $defaultValue;
    }
}
