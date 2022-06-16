<?php

namespace ZnCore\Base\Libs\App\Libs\EnvDetector;

class ConsoleEnvDetector implements EnvDetectorInterface
{

    public function isMatch(): bool
    {
        return php_sapi_name() == 'cli';

//        global $argv;
//        return isset($argv);
    }

    public function isTest(): bool
    {
        global $argv;
        $isConsoleTest = in_array('--env=test', $argv);
        return $isConsoleTest;
    }
}
