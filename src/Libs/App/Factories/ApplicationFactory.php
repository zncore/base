<?php

namespace ZnCore\Base\Libs\App\Factories;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Kernel;
use ZnLib\Console\Symfony4\Helpers\CommandHelper;
use ZnLib\Web\Symfony4\MicroApp\MicroApp;

class ApplicationFactory
{

    public static function createConsole(Kernel $kernel): Application
    {
        $config = $kernel->loadAppConfig();
        $container = $kernel->getContainer();

        $containerConfigurator = ContainerHelper::getContainerConfiguratorByContainer($container);
        $containerConfigurator->bind(Application::class, Application::class, true);

//        $container->bind(Application::class, Application::class, true);

        /** @var Application $application */
        $application = $container->get(Application::class);
        $application->getDefinition()->addOptions([
            new InputOption(
                '--env',
                '-e',
                InputOption::VALUE_OPTIONAL,
                'The environment to operate in.',
                'DEV'
            )
        ]);
        if (!empty($config['consoleCommands'])) {
            CommandHelper::registerFromNamespaceList($config['consoleCommands'], $kernel->getContainer(), $application);
        }
        return $application;
    }
    
    public static function createWeb(Kernel $kernel): MicroApp
    {
        $config = $kernel->loadAppConfig();
        $container = $kernel->getContainer();
//        $configManager = self::getConfigManager($container);
//        dd($configManager);
        $application = new MicroApp($container, $config['routeCollection']);
        return $application;
    }

    public static function createTest(Kernel $kernel)//: MicroApp
    {
        self::createConsole($kernel);
    }

    private static function getConfigManager(ContainerInterface $container): ConfigManagerInterface {
        return $container->get(ConfigManagerInterface::class);
    }
}
