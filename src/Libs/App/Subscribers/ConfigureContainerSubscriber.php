<?php

namespace ZnCore\Base\Libs\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Domain\Traits\EntityManagerTrait;

class ConfigureContainerSubscriber implements EventSubscriberInterface
{

    use EntityManagerTrait;

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_LOAD_CONFIG => 'onAfterLoadConfig',
        ];
    }

    public function onAfterLoadConfig(LoadConfigEvent $event)
    {
        $config = $event->getConfig();
        $container = $event->getKernel()->getContainer();
        ContainerHelper::configureContainer($container, $config['container']);
        $event->setConfig($config);
    }
}
