<?php

namespace ZnCore\Base\Libs\DotEnv;

interface DotEnvConfigInterface
{

    public function get(string $name, $default = null);
}
