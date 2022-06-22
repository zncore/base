<?php

namespace ZnCore\Base\Libs\DotEnv\Libs;

use Symfony\Component\Dotenv\Dotenv;
use ZnCore\Base\Libs\Composer\Helpers\ComposerHelper;
use ZnCore\Base\Patterns\Singleton\SingletonTrait;

class DotEnvIniter
{

    use SingletonTrait;

    const ROOT_PATH = __DIR__ . '/../../../../../../..';

    private $inited = false;

    public function init(string $basePath = self::ROOT_PATH, string $mode = 'main'): void
    {
        $this->checkSymfonyDotenvPackage();
        if ($this->checkInit()) {
            return;
        }
        $this->initMode($mode);
        $this->initRootDirectory($basePath);
        $this->initSymfonyDotenv($basePath);
    }

    private function checkInit(): bool
    {
        $isInited = $this->inited;
        $this->inited = true;
        return $isInited;
    }

    private function initMode(string $mode): void
    {
        if (empty($_ENV['APP_MODE'])) {
            $_ENV['APP_MODE'] = $mode;
        }
    }

    private function initRootDirectory(string $basePath): void
    {
        $_ENV['ROOT_DIRECTORY'] = realpath($basePath);
        $_ENV['ROOT_PATH'] = $_ENV['ROOT_DIRECTORY'];
    }

    private function checkSymfonyDotenvPackage(): void {
        ComposerHelper::requireAssert(Dotenv::class, 'symfony/dotenv', "4.*|5.*");
    }

    private function initSymfonyDotenv($basePath): void
    {
        $dotEnv = new Dotenv(false);
        // load all the .env files
        $dotEnv->loadEnv($basePath . '/.env');
    }
}
