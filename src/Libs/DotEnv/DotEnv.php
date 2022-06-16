<?php

namespace ZnCore\Base\Libs\DotEnv;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use RuntimeException;
use Symfony\Component\Dotenv\Dotenv as SymfonyDotenv;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;

class DotEnv
{

    const ROOT_PATH = __DIR__ . '/../../../../../..';

    static private $isInited = false;

    public static function isInited(): bool
    {
        return self::$isInited;
    }
    
    public static function init(string $basePath = self::ROOT_PATH): void
    {
        self::$isInited = true;
        $_ENV['ROOT_PATH'] = FilePathHelper::rootPath();
        $_ENV['ROOT_DIRECTORY'] = realpath(__DIR__ . '/../../../../../..');
        /*if (self::loadCachedEnvLocal($basePath)) {
            return;
        }*/
        if ( ! class_exists(SymfonyDotenv::class)) {
            throw new RuntimeException('Please run "composer require symfony/SymfonyDotenv" to load the ".env" files configuring the application.');
        }
        $dotEnv = new SymfonyDotenv(false);
        // load all the .env files
        $dotEnv->loadEnv($basePath . '/.env');
    }

    public static function get(string $name = null, $default = null)
    {
        if(!self::isInited()) {
            self::init();
        }
        $name = mb_strtoupper($name);
        if(!isset($_ENV[$name])) {
            if(func_get_args() > 1) {
                return $default;
            }
            throw new DotEnvNotFoundException("Not found DotEnv value for key \"{$name}\"");
        }
        return $_ENV[$name];
    }

    /*public static function get(string $path = null, $default = null)
    {
        if (empty(self::$map)) {
            self::forgeMap();
        }
        return ArrayHelper::getValue(self::$map, $path, $default);
    }

    private static function forgeMap(): void
    {
        foreach ($_ENV as $name => $value) {
            $pureName = $name;
            $pureName = strtolower($pureName);
            $pureName = str_replace('_', '.', $pureName);
            ArrayHelper::set(self::$map, $pureName, $value);
        }
    }

    private static function loadCachedEnvLocal(string $basePath): bool
    {
        // Load cached env vars if the .env.local.php file exists
        // Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
        $env = @include $basePath . '/.env.local.php';
        if ( ! is_array($env)) {
            return false;
        }
        foreach ($env as $key => $value) {
            self::setEnvValue($key, $value);
        }
        return true;
    }

    private static function setEnvValue(string $key, $value): void
    {
        if(isset($_ENV[$key])) {
            return;
        }
        $isHeader = 0 === strpos($key, 'HTTP_');
        $hasValueInServer = isset($_SERVER[$key]) && ! $isHeader;
        $_ENV[$key] = $hasValueInServer ? $_SERVER[$key] : $value;
    }*/

}
