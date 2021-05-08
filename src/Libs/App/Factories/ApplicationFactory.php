<?php

namespace ZnCore\Base\Libs\App\Factories;

use Packages\Application\Libs\Kernel;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use ZnLib\Console\Symfony4\Helpers\CommandHelper;

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
}
