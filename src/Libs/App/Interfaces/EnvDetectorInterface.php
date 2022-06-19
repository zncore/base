<?php

namespace ZnCore\Base\Libs\App\Interfaces;

use ZnCore\Base\Libs\ConfigManager\Interfaces\ConfigManagerInterface;

interface EnvDetectorInterface
{

    public function isMatch(): bool;

    public function isTest(): bool;
}
