<?php

namespace ZnCore\Base\Libs\App\Factories;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use ZnCore\Base\Libs\App\Kernel;
use ZnLib\Console\Symfony4\Helpers\CommandHelper;
use ZnLib\Web\Symfony4\MicroApp\MicroApp;

class ApplicationFactory
{

    public static function createConsole(Kernel $kernel): Application
    {
        $config = $kernel->loadAppConfig();
        $container = $kernel->getContainer();
        $container->bind(Application::class, Application::class, true);
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
        $application = new MicroApp($container, $config['routeCollection']);
        return $application;
    }
}
