<?php

namespace ZnCore\Base\FileSystem\Helpers;

use ZnCore\Base\FileSystem\Helpers\FileHelper;

class FileStorageHelper
{

    public static function isLocked(string $filename): bool
    {
        if(!file_exists($filename)) {
            return false;
        }
        $fp = fopen($filename, 'r+');
        if (!flock($fp, LOCK_EX|LOCK_NB, $wouldblock)) {
            if ($wouldblock) {
                // другой процесс удерживает блокировку
                return true;
            } else {
                // не удалось заблокировать по другой причине, например. нет такого файла
                throw new \Exception('не удалось заблокировать по другой причине, например. нет такого файла');
//                return true;
            }
        } else {
            // блокировка получена
            flock($fp, LOCK_UN); // снятие блокировки
            fclose($fp);
            return false;
        }
    }

    public static function remove(string $path)
    {
        $path = FilePathHelper::pathToAbsolute($path);
        if (is_dir($path)) {
            FileHelper::removeDirectory($path);
            return true;
        } elseif (is_file($path)) {
            FileHelper::unlink($path);
            return true;
        }
        return false;
    }

    public static function copy(string $sourceFile, string $targetFile, $dirAccess = 0777)
    {
        $sourceData = FileStorageHelper::load($sourceFile);
        FileStorageHelper::save($targetFile, $sourceData, null, null, $dirAccess);
    }

    public static function touchFile($fileName, $data = null, $flags = null, $context = null, int $dirAccess = 0777)
    {
        $fileName = FileHelper::normalizePath($fileName);
        if (!file_exists($fileName)) {
            self::save($fileName, $data, $flags, $context, $dirAccess);
        }
    }

    public static function touchDirectory(string $dirName, int $dirAccess = 0777)
    {
        if (!is_dir($dirName)) {
            FileHelper::createDirectory($dirName, $dirAccess);
        }
    }

    public static function save(string $fileName, $data, $flags = null, $context = null, int $dirAccess = 0777)
    {
        $fileName = FileHelper::normalizePath($fileName);
        $dirName = dirname($fileName);
        self::touchDirectory($dirName, $dirAccess);
        return file_put_contents($fileName, $data, $flags, $context);
    }

    public static function load(string $fileName, $flags = null, $context = null, int $offset = null)
    {
        $fileName = FileHelper::normalizePath($fileName);
        if (!self::has($fileName)) {
            return null;
        }
        return file_get_contents($fileName, $flags, $context, $offset);
    }

    public static function has(string $fileName): bool
    {
        $fileName = FileHelper::normalizePath($fileName);
        return is_file($fileName) || is_dir($fileName);
    }
}
