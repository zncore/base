<?php

namespace ZnCore\Base\App\Interfaces;

use ZnCore\Base\ConfigManager\Interfaces\ConfigManagerInterface;

interface EnvDetectorInterface
{

    public function isMatch(): bool;

    public function isTest(): bool;
}
