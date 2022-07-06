<?php

namespace ZnCore\Base\Env\Helpers;

use Symfony\Component\Uid\Uuid;
use ZnCore\FileSystem\Helpers\FileHelper;

class TempHelper
{

    private static $uuid = null;
    private static $removeDirs = [];

    public static function getTmpDirectory(string $name): string
    {
        $tmpDir = self::getTempDirectory() . '/' . $name . '/' . self::getUuid();
        self::createDirectory($tmpDir);
        return $tmpDir;
    }

    public static function shutdown()
    {
        foreach (self::$removeDirs as $dirPath) {
            FileHelper::removeDirectory($dirPath);
        }
    }

    public static function createDirectory(string $dirPath)
    {
        FileHelper::createDirectory($dirPath);
        self::addRemoveDirectory($dirPath);
    }

    private static function addRemoveDirectory(string $dirPath)
    {
        if (empty(self::$removeDirs)) {
            register_shutdown_function([__CLASS__, 'shutdown']);
        }
        self::$removeDirs[] = $dirPath;
    }

    private static function getTempDirectory(): string
    {
        return $_ENV['TEMP_DIRECTORY'] ?? sys_get_temp_dir();
    }

    private static function getUuid(): string
    {
        if (self::$uuid == null) {
            self::$uuid = Uuid::v4()->toRfc4122();
        }
        return self::$uuid;
    }
}
