<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

DeprecateHelper::hardThrow();

class DotEnvConfig implements DotEnvConfigInterface
{

    private $env;

    public function __construct(array $env)
    {
        $this->env = $env;
    }

    public function get(string $name, $default = null) {
        return ArrayHelper::getValue($this->env, $name, $default);
    }
}
