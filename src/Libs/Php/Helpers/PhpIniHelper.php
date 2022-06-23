<?php

namespace ZnCore\Base\Libs\Php\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;

class PhpIniHelper
{

    /**
     * Checks if PHP configuration option (from php.ini) is on.
     * @param string $name configuration option name.
     * @return bool option is on.
     */
    public static function isOn($name): bool
    {
        $value = ini_get($name);
        if (empty($value)) {
            return false;
        }
        return ((int)$value === 1 || strtolower($value) === 'on');
    }

    /**
     * Checks if PHP configuration option (from php.ini) is off.
     * @param string $name configuration option name.
     * @return bool option is off.
     */
    public static function isOff($name): bool
    {
        $value = ini_get($name);
        if (empty($value)) {
            return true;
        }
        return (strtolower($value) === 'off');
    }

    public static function isEmpty($name): bool
    {
        $value = ini_get($name);
        if (empty($value)) {
            return true;
        }

        return (strlen($value) === 0);
    }

    public static function isNotEmpty($name): bool
    {
        return ! self::checkPhpIniEmpty($name);
    }

}