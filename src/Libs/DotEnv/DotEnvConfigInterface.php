<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Helpers\DeprecateHelper;

DeprecateHelper::hardThrow();

interface DotEnvConfigInterface
{

    public function get(string $name, $default = null);
}
