<?php

namespace ZnCore\Base\Libs\App\Facades;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Kernel;
use ZnCore\Base\Libs\App\Loaders\ContainerConfigLoader;
use ZnCore\Base\Libs\DotEnv\DotEnv;

DeprecateHelper::softThrow();

class ConsoleAppFacade
{

    public static function init(ContainerInterface $container, array $containerConfigArray = []): Application
    {
        DotEnv::init(__DIR__ . '/../../../../../../..');
        EnvHelper::setErrorVisibleFromEnv();
        $kernel = new Kernel('console');
        $kernel->setContainer($container);
        $mainContainerConfig = [
            __DIR__ . '/../../../../../../../vendor/zntool/package/bin/container.php',
        ];
        $kernel->setLoader(new ContainerConfigLoader(ArrayHelper::merge($mainContainerConfig, $containerConfigArray)));
        $mainConfig = $kernel->loadAppConfig();

        $containerConfigurator = ContainerHelper::getContainerConfiguratorByContainer($container);
        $containerConfigurator->bindContainerSingleton();

        /*$containerConfigurator->singleton(Application::class, Application::class);
        $containerConfigurator->singleton(ContainerInterface::class, function (ContainerInterface $container) {
            return $container;
        });*/

        /*$container->singleton(Application::class, Application::class);
        $container->singleton(ContainerInterface::class, function (ContainerInterface $container) {
            return $container;
        });*/

        $application = $container->get(Application::class);
        return $application;
    }
}
