<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App1\ClassSum;
use App1\ClassMultiplication;
use App1\ClassPow;
use ZnCore\FileSystem\Helpers\FileStorageHelper;

require_once __DIR__ . '/../../classes/ClassSum.php';
require_once __DIR__ . '/../../classes/ClassMultiplication.php';
require_once __DIR__ . '/../../classes/ClassPow.php';

return function(ContainerConfigurator $configurator) {
    /*$configurator->parameters()
        // ...
        ->set('mailer.transport', 'sendmail')
    ;*/

    /*$services = $configurator->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    $services->load('App1\\', '../../classes/*')
        ->exclude('../../classes/Cc.php')->public();*/

//    $services = $configurator->services();

    /*$services
        ->set(ClassSum::class, ClassSum::class)
        ->public()
    ;*/

};
