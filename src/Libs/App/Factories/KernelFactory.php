<?php

namespace ZnCore\Base\Libs\App\Factories;

use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\App\Kernel;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnLib\Web\Symfony4\MicroApp\MicroApp;

class KernelFactory
{

    public static function createConsoleKernel(array $bundles = []): Kernel
    {
        EnvHelper::prepareTestEnv();
        DotEnv::init();
        $bundleLoader = new BundleLoader($bundles, ['i18next', 'container', 'console', 'migration']);
        $kernel = new Kernel('console');
        $kernel->setLoader($bundleLoader);
        return $kernel;
    }

    public static function createWebKernel(array $bundles = []): Kernel
    {
        EnvHelper::prepareTestEnv();
        DotEnv::init();
        //CorsHelper::autoload();
        //EnvHelper::setErrorVisibleFromEnv();
        $bundleLoader = new BundleLoader($bundles, ['i18next', 'container', 'symfonyWeb']);
        $kernel = new Kernel('web');
        $kernel->setLoader($bundleLoader);
        return $kernel;
    }
}
