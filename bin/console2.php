<?php

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use ZnCore\Base\Libs\App\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnLib\Console\Symfony4\Base\BaseConsoleApp;
use ZnLib\Telegram\Domain\Libs\Loaders\BundleLoaders\TelegramRoutesLoader;
use ZnLib\Telegram\Domain\Subscribers\LoadTelegramRoutesSubscriber;
use ZnCore\Base\Libs\App\Interfaces\AppInterface;
use ZnCore\Base\Libs\App\Libs\ZnCore;
use ZnCore\Base\Libs\Event\Interfaces\EventDispatcherConfiguratorInterface;

define('MICRO_TIME', microtime(true));

require __DIR__ . '/../../../../vendor/autoload.php';

$container = new Container();
$znCore = new ZnCore($container);
$znCore->init();

/** @var ContainerConfiguratorInterface $containerConfigurator */
$containerConfigurator = $container->get(ContainerConfiguratorInterface::class);

/** @var EventDispatcherConfiguratorInterface $eventDispatcherConfigurator */
$eventDispatcherConfigurator = $container->get(EventDispatcherConfiguratorInterface::class);

//$eventDispatcherConfigurator->addSubscriber(LoadTelegramRoutesSubscriber::class);

//if(/*in_array('telegramRoutes', $import) &&*/ class_exists(LoadTelegramRoutesSubscriber::class)) {
//    $bundleLoader->addLoaderConfig('telegramRoutes', TelegramRoutesLoader::class);
//    $kernel->addSubscriber(LoadTelegramRoutesSubscriber::class);
//}

$mainEnv = DotEnv::loadFromFile(DotEnv::ROOT_PATH . '/.env');
$consoleAppClass = $mainEnv['CONSOLE_APP_CLASS'] ?? \ZnLib\Console\Domain\Libs\ConsoleApp::class;
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
]);
$appFactory->init();

/** @var Application $application */
$application = $container->get(Application::class);
$application->run();
