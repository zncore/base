<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use RuntimeException;
use Symfony\Component\Dotenv\Dotenv as SymfonyDotenv;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Helpers\EnvHelper;
use ZnCore\Base\Libs\DotEnv\Libs\DotEnvIniter;
use ZnCore\Base\Libs\DotEnv\Libs\DotEnvLoader;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;

class DotEnv
{

    const ROOT_PATH = __DIR__ . '/../../../../../..';

    static private $isInited = false;

    public static function isInited(): bool
    {
        return self::$isInited;
    }

//    public static function loadFromFile(string $path, string $key = null, $default = null): array {
//        $loader = new DotEnvLoader();
//        return $loader->loadFromFile($path, $key, $default);
//
//
//        /*$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
//        $path = \ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper::rootPath() . '/.env';
//        $parsedEnv = $dotEnv->parse(file_get_contents($path), $path);
//        if($key) {
//            return ArrayHelper::get($parsedEnv, $key, $default);
//        }
//        return $parsedEnv;*/
//    }

    /*public static function lazyInit(string $basePath = self::ROOT_PATH, string $mode = 'main'): void
    {
        if(self::$isInited) {
            return;
        }
        self::initDotEnv($basePath, $mode);
    }*/

    public static function init(string $basePath = self::ROOT_PATH, string $mode = 'main'): void
    {
        if(self::$isInited) {
            return;
//            throw new \Exception('DotEnv already inited!');
        }
        self::$isInited = true;
        (new DotEnvIniter($basePath, $mode))->init();
//        self::initDotEnv($basePath, $mode);
    }

//    private static function initDotEnv(string $basePath = self::ROOT_PATH, string $mode = 'main') {
//        if(empty($_ENV['APP_MODE'])) {
//            /*if(!$mode) {
//                $mode = EnvHelper::isTestEnv() ? 'test' : 'main';
//            }*/
//            $_ENV['APP_MODE'] = $mode;
//        }
//
//        $_ENV['ROOT_PATH'] = FilePathHelper::rootPath();
//        $_ENV['ROOT_DIRECTORY'] = realpath(__DIR__ . '/../../../../../..');
//        /*if (self::loadCachedEnvLocal($basePath)) {
//            return;
//        }*/
//        if ( ! class_exists(SymfonyDotenv::class)) {
//            throw new RuntimeException('Please run "composer require symfony/SymfonyDotenv" to load the ".env" files configuring the application.');
//        }
//        $dotEnv = new SymfonyDotenv(false);
//        // load all the .env files
//        $dotEnv->loadEnv($basePath . '/.env');
//    }

    public static function get(string $name = null, $default = null)
    {
        /*if(!self::isInited()) {
            throw new \Exception('DotEnv not inited!');
            self::init();
        }*/
        $name = mb_strtoupper($name);
        return $_ENV[$name] ?? $default;

        /*if(!isset($_ENV[$name])) {
            if(func_get_args() > 1) {
                return $default;
            }
            throw new DotEnvNotFoundException("Not found DotEnv value for key \"{$name}\"");
        }
        return $_ENV[$name];*/
    }
}
