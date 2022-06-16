<?php

namespace ZnCore\Base\Libs\App\Libs\EnvDetector;

use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;

interface EnvDetectorInterface
{

    public function isMatch(): bool;

    public function isTest(): bool;
}
