<?php

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnLib\Console\Symfony4\Base\BaseConsoleApp;
use ZnSandbox\Sandbox\App\Interfaces\AppInterface;
use ZnSandbox\Sandbox\App\Libs\ZnCore;
//use ZnCore\Base\Console\Libs\ConsoleApp;

class ConsoleApp extends BaseConsoleApp
{

    protected function bundles(): array
    {
        $bundles = [
//            new ZnCore\Base\Libs\App\Bundle(['all']),

            ZnTool\Package\Bundle::class,
            ZnLib\Db\Bundle::class,
            ZnLib\Fixture\Bundle::class,
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

define('MICRO_TIME', microtime(true));

require __DIR__ . '/../../../../vendor/autoload.php';

$container = Container::getInstance();
$znCore = new ZnCore($container);
$znCore->init();

$znCore->addContainerConfig(function (ContainerConfiguratorInterface $containerConfigurator) {
    $containerConfigurator->singleton(AppInterface::class, ConsoleApp::class);
});

/** @var AppInterface $appFactory */
$appFactory = $container->get(AppInterface::class);
$appFactory->init();

/** @var Application $application */
$application = $container->get(Application::class);
$application->run();
