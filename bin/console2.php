<?php

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use ZnCore\Base\Libs\App\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnLib\Console\Symfony4\Base\BaseConsoleApp;
use ZnSandbox\Sandbox\App\Interfaces\AppInterface;
use ZnSandbox\Sandbox\App\Libs\ZnCore;
//use ZnCore\Base\Console\Libs\ConsoleApp;

define('MICRO_TIME', microtime(true));

class ConsoleApp extends BaseConsoleApp
{

    protected function bundles(): array
    {
        $bundles = [
//            new ZnCore\Base\Libs\App\Bundle(['all']),

            ZnTool\Package\Bundle::class,
            ZnDatabase\Base\Bundle::class,
            ZnDatabase\Tool\Bundle::class,
            ZnDatabase\Fixture\Bundle::class,
            ZnDatabase\Migration\Bundle::class,
            ZnTool\Generator\Bundle::class,
            ZnTool\Stress\Bundle::class,
            ZnBundle\Queue\Bundle::class,
        ];

        EnvHelper::prepareTestEnv();

        if (DotEnv::get('BUNDLES_CONFIG_FILE')) {
            $bundles = ArrayHelper::merge($bundles, include __DIR__ . '/../../../../' . DotEnv::get('BUNDLES_CONFIG_FILE'));
        }
        return $bundles;
    }
}

require __DIR__ . '/../../../../vendor/autoload.php';

$container = new Container();
$znCore = new ZnCore($container);
$znCore->init();

/** @var ContainerConfiguratorInterface $containerConfigurator */
$containerConfigurator = $container->get(ContainerConfiguratorInterface::class);

$containerConfigurator->singleton(AppInterface::class, ConsoleApp::class);
/*$znCore->addContainerConfig(function (ContainerConfiguratorInterface $containerConfigurator) {
    $containerConfigurator->singleton(AppInterface::class, ConsoleApp::class);
});*/

/** @var AppInterface $appFactory */
$appFactory = $container->get(AppInterface::class);
$appFactory->init();

/** @var Application $application */
$application = $container->get(Application::class);
$application->run();
