<?php

use Symfony\Component\Dotenv\Command\DotenvDumpCommand;
use Symfony\Component\Dotenv\Command\DebugCommand;
use ZnCore\Base\App\Helpers\EnvHelper;
use ZnCore\Base\FileSystem\Helpers\FilePathHelper;


return [
    'definitions' => [
        DotenvDumpCommand::class => function() {
            $env = EnvHelper::getAppEnv();
            $path = FilePathHelper::rootPath();

            return new DotenvDumpCommand($path, $env);
        },
        DebugCommand::class => function(\Psr\Container\ContainerInterface $container) {
            $env = EnvHelper::getAppEnv();
            $path = FilePathHelper::rootPath();

            return new DebugCommand($env, $path);
        },
    ],
];
