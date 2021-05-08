<?php

namespace ZnCore\Base\Helpers;

use Composer\Autoload\ClassLoader;
use ZnCore\Base\Exceptions\NotFoundDependencyException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

class ComposerHelper
{

    private static $autoloadPsr4;

    /**
     * Требовать установку composer-пакета
     * @param string $className
     * @param string $packageName
     * @param string|null $version
     * @throws NotFoundDependencyException
     * @example ComposerHelper::requireAssert(ZnGroup\Package\Class::class, 'zngroup/package', 'v1.23.45');
     */
    public static function requireAssert(string $className, string $packageName, string $version = null): void
    {
        if( ! class_exists($className) && ! interface_exists($className) && ! trait_exists($className)) {
            $package = $packageName;
            if(!empty($version)) {
                $package .= ":$version";
            }
            $message = "Class \"$className\" not exists!\n";
            $message .= "\"$packageName\" package not loaded! \nRun the command: \"composer require $package\"";
            throw new NotFoundDependencyException($message);
        }
    }

    /**
     * Зарегистрировать пространство имен
     * @param string $namespace
     * @param string $path
     * @example ComposerHelper::register('App', __DIR__ . '/../src');
     */
    public static function register(string $namespace, string $path): void
    {
        //$path = realpath($path);
        $function = function ($className) use ($namespace, $path) {
            if (strpos($className, $namespace . '\\') !== 0 || $className == $namespace) {
                return;
            }
            $fileName = str_replace($namespace, $path, $className);
            if (strpos($path, '.php') === false) {
                $fileName .= '.php';
            }
            if (strpos($path, 'phar://') === 0) {
                include_once $fileName;
            } else {
                $fileName = str_replace('\\', '/', $fileName);
                if (!file_exists($fileName)) {
                    //exit($fileName);

                    exit('Class "' . $className . '" not found!');
                    //throw new FileNotFoundException('Class "' . $className . '" not found!');
                }
                include_once $fileName;
            }
        };
        spl_autoload_register($function);
        self::add($namespace, $path);
    }

    private static function add(string $namespace, string $path)
    {
        $namespace = trim($namespace, '/\\');
        self::$autoloadPsr4[$namespace . '\\'] = [
            realpath($path)
        ];
    }

    public static function getPsr4Path($path)
    {
        self::ensure();
        $path = self::normalizePath($path);
        $pathItems = explode('\\', $path);
        $paths = self::find($pathItems);
        return FileHelper::normalizePath(ArrayHelper::first($paths));
    }

    private static function find(array $pathItems): array
    {
        $paths = [];
        $pp = '';
        for ($i = 0; $i <= count($pathItems) - 1; $i++) {
            $pp .= $pathItems[$i] . '\\';
            unset($pathItems[$i]);
            $dirs = ArrayHelper::getValue(self::$autoloadPsr4, $pp);
            if ($dirs) {
                foreach ($dirs as $dir) {
                    $relativeDir = implode('\\', $pathItems);
                    $path = trim($dir . '\\' . $relativeDir, '\\');
                    $paths[$pp . $relativeDir] = $path;
                }
            }
        }
        return $paths;
    }

    private static function normalizePath(string $path): string
    {
        $path = str_replace('/', '\\', $path);
        $path = trim($path, '\\@');
        return $path;
    }

    private static function ensure()
    {
        if (self::$autoloadPsr4) {
            return;
        }
        self::$autoloadPsr4 = include FileHelper::rootPath() . '/vendor/composer/autoload_psr4.php';
    }

}