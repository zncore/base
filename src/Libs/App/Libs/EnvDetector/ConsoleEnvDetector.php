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
        $isConsoleTest = /*isset($argv) && */in_array('--env=test', $argv);
//        $isWebTest = isset($_GET['env']) && $_GET['env'] == 'test';
//        $isWebTest = (isset($_SERVER['HTTP_ENV_NAME']) && $_SERVER['HTTP_ENV_NAME'] == 'test') || (isset($_GET['env']) && $_GET['env'] == 'test');
        return $isConsoleTest /*|| $isWebTest*/;
    }
}
