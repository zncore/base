<?php

namespace ZnCore\Base\Libs\DotEnv\Domain\Libs;

use Symfony\Component\Dotenv\Dotenv;
use ZnCore\Base\Libs\Composer\Helpers\ComposerHelper;
use ZnCore\Base\Libs\DotEnv\Domain\Enums\DotEnvModeEnum;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;
use ZnCore\Base\Patterns\Singleton\SingletonTrait;

class DotEnvBootstrap
{

    use SingletonTrait;

    private $inited = false;

    public static function load(string $mode = DotEnvModeEnum::MAIN, string $basePath = null) {
        DotEnvBootstrap::getInstance()->init($mode, $basePath);
    }

    public function init(string $mode = DotEnvModeEnum::MAIN, string $basePath = null): void
    {
        if ($this->checkInit()) {
            return;
        }
        $this->checkSymfonyDotenvPackage();

        $basePath = $basePath ?: FilePathHelper::rootPath();
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

    private function checkSymfonyDotenvPackage(): void
    {
        ComposerHelper::requireAssert(Dotenv::class, 'symfony/dotenv', "4.*|5.*");
    }

    private function initSymfonyDotenv($basePath): void
    {
//        (new Dotenv('APP_ENV', 'APP_DEBUG'))->bootEnv($basePath . '/.env', 'dev', ['test'], true);


        $dotEnv = new Dotenv(false);
        $dotEnv->bootEnv($basePath . '/.env', 'dev', ['test'], true);


        // load all the .env files
//        $dotEnv->loadEnv($basePath . '/.env');
    }
}
