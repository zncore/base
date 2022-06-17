<?php

namespace ZnCore\Base\Libs\App\Subscribers;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;

DeprecateHelper::hardThrow();

class ConfigureContainerSubscriber implements EventSubscriberInterface
{

//    use EntityManagerTrait;
    use ContainerAwareTrait;

    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_LOAD_CONFIG => 'onAfterLoadConfig',
        ];
    }

    public function onAfterLoadConfig(LoadConfigEvent $event)
    {
        $config = $event->getConfig();
//        $container = $event->getKernel()->getContainer();
//        dd($config['container']);
        if (!empty($config['container'])) {
            ContainerHelper::configureContainer($this->container, $config['container']);
        }
        //$event->setConfig($config);
    }
}
