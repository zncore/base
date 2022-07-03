<?php

namespace ZnCore\Base\EventDispatcher\Libs;

use ZnCore\Base\Container\Libs\Container;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Instance\Helpers\ClassHelper;
use ZnCore\Base\Instance\Libs\Resolvers\InstanceResolver;
use ZnCore\Base\Container\Traits\ContainerAwareTrait;
use ZnCore\Base\EventDispatcher\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\EventDispatcher\Traits\EventDispatcherTrait;

class EventDispatcherConfigurator implements EventDispatcherConfiguratorInterface
{

    use ContainerAwareTrait;
    use EventDispatcherTrait;

    /*private $drivers = [
        Container::class => [
            'class' => IlluminateContainerConfigurator::class,
        ]
    ];*/
    /** @var Container */
    private $eventDispatcher;

//    private $configurator;

    public function __construct(ContainerInterface $container, EventDispatcherInterface $eventDispatcher)
    {
        $this->setContainer($container);
        $this->setEventDispatcher($eventDispatcher);
//        $this->configurator = $this->getContainerConfiguratorByContainer($container);
    }

    public function addSubscriber($subscriberDefinition): void
    {
        $subscriberInstance = $this->forgeSubscriberInstance($subscriberDefinition);
        $this->getEventDispatcher()->addSubscriber($subscriberInstance);
    }

    private function forgeSubscriberInstance($subscriberDefinition): EventSubscriberInterface
    {
        if ($subscriberDefinition instanceof EventSubscriberInterface) {
            $subscriberInstance = $subscriberDefinition;
        } else {
//            $instanceResolver = new InstanceResolver($this->getContainer());
//            $subscriberInstance = $instanceResolver->create($subscriberDefinition);
//dd($subscriberInstance);
            $subscriberInstance = ClassHelper::createInstance($subscriberDefinition, [], $this->getContainer());
        }
        return $subscriberInstance;
    }
}
