<?php

namespace ZnCore\Base\Libs\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Domain\Helpers\EntityManagerHelper;
use ZnCore\Domain\Traits\EntityManagerTrait;

class ConfigureEntityManagerSubscriber implements EventSubscriberInterface
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
        if (isset($config['container']['entities'])) {
            EntityManagerHelper::bindEntityManager($container, $config['container']['entities']);
            unset($config['container']['entities']);
        }
        $event->setConfig($config);
    }
}
