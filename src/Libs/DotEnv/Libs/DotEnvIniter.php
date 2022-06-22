<?php

namespace ZnCore\Base\Libs\DotEnv\Libs;

use RuntimeException;
use Symfony\Component\Dotenv\Dotenv as SymfonyDotenv;
use ZnCore\Base\Libs\Composer\Helpers\ComposerHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;

class DotEnvIniter
{

    private $basePath;
    private $mode;

    public function __construct(string $basePath = self::ROOT_PATH, string $mode = 'main')
    {
        $this->basePath = $basePath;
        $this->mode = $mode;
    }

    public function init()
    {
        if (empty($_ENV['APP_MODE'])) {
            $_ENV['APP_MODE'] = $this->mode;
        }
        $_ENV['ROOT_PATH'] = FilePathHelper::rootPath();
        $_ENV['ROOT_DIRECTORY'] = realpath(__DIR__ . '/../../../../../../..');

        if (!class_exists(SymfonyDotenv::class)) {
            ComposerHelper::requireAssert(SymfonyDotenv::class, 'symfony/SymfonyDotenv', "4.*|5.*");
//            throw new RuntimeException('Please run "composer require symfony/SymfonyDotenv" to load the ".env" files configuring the application.');
        }
        $dotEnv = new SymfonyDotenv(false);
        // load all the .env files
        $dotEnv->loadEnv($this->basePath . '/.env');
    }
}
