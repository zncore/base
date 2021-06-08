<?php

namespace ZnCore\Base\Libs\App\Factories;

use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Kernel;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\DotEnv\DotEnv;
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

    public static function createConsoleKernel(array $bundles = []): Kernel
    {
        self::init();
        $bundleLoader = new BundleLoader($bundles, ['i18next', 'container', 'console', 'migration']);
        $kernel = new Kernel('console');
        $kernel->setLoader($bundleLoader);
        return $kernel;
    }

    public static function createWebKernel(array $bundles = [], $load = ['i18next', 'container', 'symfonyWeb']): Kernel
    {
        self::init();
        $bundleLoader = new BundleLoader($bundles, $load);
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
