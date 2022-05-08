<?php

namespace ZnCore\Base\Libs\FileSystem\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

class FileStorageHelper
{

    public static function remove($path)
    {
        $path = FilePathHelper::pathToAbsolute($path);
        if (is_dir($path)) {
            FileHelper::removeDirectory($path);
            return true;
        } elseif (is_file($path)) {
            unlink($path);
            return true;
        }
        return false;
    }

    public static function copy($sourceFile, $targetFile, $dirAccess = 0777)
    {
        $sourceData = FileStorageHelper::load($sourceFile);
        FileStorageHelper::save($targetFile, $sourceData, null, null, $dirAccess);
    }

    public static function touch($fileName, $data = null, $flags = null, $context = null, $dirAccess = 0777)
    {
        $fileName = FileHelper::normalizePath($fileName);
        if (!file_exists($fileName)) {
            self::save($fileName, $data, $flags, $context, $dirAccess);
        }
    }

    public static function save($fileName, $data, $flags = null, $context = null, $dirAccess = 0777)
    {
        $fileName = FileHelper::normalizePath($fileName);
        $dirName = dirname($fileName);
        if (!is_dir($dirName)) {
            self::createDirectory($dirName, $dirAccess);
        }
        return file_put_contents($fileName, $data, $flags, $context);
    }

    public static function load($fileName, $flags = null, $context = null, $offset = null, $maxLen = null)
    {
        $fileName = FileHelper::normalizePath($fileName);
        if (!self::has($fileName)) {
            return null;
        }
        return file_get_contents($fileName, $flags, $context, $offset);
    }

    public static function has($fileName): bool
    {
        $fileName = FileHelper::normalizePath($fileName);
        return is_file($fileName) || is_dir($fileName);
    }
}
