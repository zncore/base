<?php

namespace ZnCore\Base\Libs\App\Factories;

use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Kernel;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Contract\Kernel\Interfaces\KernelInterface;
use ZnLib\Telegram\Domain\Libs\Loaders\BundleLoaders\TelegramRoutesLoader;
use ZnLib\Telegram\Domain\Subscribers\LoadTelegramRoutesSubscriber;
use ZnTool\Dev\VarDumper\Facades\SymfonyDumperFacade;

class KernelFactory
{

    public static function initVarDumper()
    {
        if(!class_exists(SymfonyDumperFacade::class)) {
            return;
        }
        if (isset($_ENV['VAR_DUMPER_OUTPUT'])) {
            SymfonyDumperFacade::dumpInConsole($_ENV['VAR_DUMPER_OUTPUT']);
        }
    }

    public static function createConsoleKernel(array $bundles = [], $import = ['i18next', 'container', 'console', 'migration']): KernelInterface
    {
        self::init();
        $bundleLoader = new BundleLoader($bundles, $import);
        $kernel = new Kernel('console');
        if(in_array('telegramRoutes', $import) && class_exists(LoadTelegramRoutesSubscriber::class)) {
            $bundleLoader->addLoaderConfig('telegramRoutes', TelegramRoutesLoader::class);
            $kernel->addSubscriber(LoadTelegramRoutesSubscriber::class);
        }
        $kernel->setLoader($bundleLoader);
        return $kernel;
    }

    public static function createWebKernel(array $bundles = [], $import = ['i18next', 'container', 'symfonyWeb']): KernelInterface
    {
        self::init();
        $bundleLoader = new BundleLoader($bundles, $import);
        $kernel = new Kernel('web');
        $kernel->setLoader($bundleLoader);
        return $kernel;
    }

    public static function init() {
        $_ENV['ROOT_PATH'] = FileHelper::rootPath();
        EnvHelper::prepareTestEnv();
        DotEnv::init();
        self::initVarDumper();
        //CorsHelper::autoload();
        EnvHelper::setErrorVisibleFromEnv();
    }
}
