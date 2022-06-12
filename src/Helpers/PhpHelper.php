<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;

class PhpHelper
{

    public static function requireFromDirectory(string $directory, bool $isRecursive = false) {
        $directory = rtrim($directory, '/');
        $libs = FindFileHelper::scanDir($directory);
        foreach ($libs as $lib) {
            $path = $directory . '/' . $lib;
            if(is_file($path)) {
                if(is_file($path) && FilePathHelper::fileExt($lib) == 'php') {
                    require_once $path;
                }
            } elseif(is_dir($path)) {
                self::requireFromDirectory($path, $isRecursive);
            }
        }
    }

    /**
     * Checks if the given PHP extension is available and its version matches the given one.
     * @param string $extensionName PHP extension name.
     * @param string $version required PHP extension version.
     * @param string $compare comparison operator, by default '>='
     * @return bool if PHP extension version matches.
     */
    public static function checkPhpExtensionVersion($extensionName, $version, $compare = '>='): bool
    {
        if (!extension_loaded($extensionName)) {
            return false;
        }
        $extensionVersion = phpversion($extensionName);
        if (empty($extensionVersion)) {
            return false;
        }
        if (strncasecmp($extensionVersion, 'PECL-', 5) === 0) {
            $extensionVersion = substr($extensionVersion, 5);
        }

        return version_compare($extensionVersion, $version, $compare);
    }

    public static function isCallable($value)
    {
        return $value instanceof \Closure || is_callable($value);
    }

    public static function runValue($value, $params = [])
    {
        if (self::isCallable($value)) {
            $value = call_user_func_array($value, $params);
        }
        return $value;
    }

    public static function isValidName($name)
    {
        if (!is_string($name)) {
            return false;
        }
        // todo: /^[\w]{1}[\w\d_]+$/i
        return preg_match('/([a-zA-Z0-9_]+)/', $name);
    }

}