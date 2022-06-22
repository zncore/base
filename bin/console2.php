<?php

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use ZnCore\Base\Libs\App\Interfaces\AppInterface;
use ZnCore\Base\Libs\App\Libs\ZnCore;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\DotEnv\Domain\Libs\DotEnv;
use ZnCore\Base\Libs\DotEnv\Domain\Libs\DotEnvLoader;
use ZnCore\Base\Libs\EventDispatcher\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;
use ZnLib\Console\Domain\Libs\ConsoleApp;

define('MICRO_TIME', microtime(true));

require __DIR__ . '/../../../../vendor/autoload.php';

$container = new Container();
$znCore = new ZnCore($container);
$znCore->init();

/** @var ContainerConfiguratorInterface $containerConfigurator */
$containerConfigurator = $container->get(ContainerConfiguratorInterface::class);

/** @var EventDispatcherConfiguratorInterface $eventDispatcherConfigurator */
$eventDispatcherConfigurator = $container->get(EventDispatcherConfiguratorInterface::class);

//$mainEnv = DotEnv::loadFromFile(DotEnv::ROOT_PATH . '/.env');
$loader = new DotEnvLoader();
$mainEnv = $loader->loadFromFile(FilePathHelper::rootPath() . '/.env');
$consoleAppClass = $mainEnv['CONSOLE_APP_CLASS'] ?? ConsoleApp::class;
$containerConfigurator->singleton(AppInterface::class, $consoleAppClass);

/** @var AppInterface $appFactory */
$appFactory = $container->get(AppInterface::class);

$appFactory->addBundles([
    \ZnTool\Package\Bundle::class,
    \ZnDatabase\Base\Bundle::class,
    \ZnDatabase\Tool\Bundle::class,
    \ZnDatabase\Fixture\Bundle::class,
    \ZnDatabase\Migration\Bundle::class,
    \ZnTool\Generator\Bundle::class,
    \ZnTool\Stress\Bundle::class,
    \ZnBundle\Queue\Bundle::class,
    \ZnCore\Base\Libs\DotEnv\Bundle::class,
]);
$appFactory->init();

/** @var Application $application */
$application = $container->get(Application::class);
$application->run();
