<?php

namespace ZnCore\Base\Libs\Event\Traits;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;

trait EventDispatcherTrait
{

    /** @var EventDispatcher */
    private $eventDispatcher;

    private $subscriberDefinittions = [];

    public function subscribes(): array
    {
        return [

        ];
    }

    protected function initEvent()
    {
        if ($this->eventDispatcher == null) {
            $this->eventDispatcher = new EventDispatcher();
            $this->initSubscribers($this->subscribes());
        }
        if ($this->subscriberDefinittions) {
            $this->initSubscribers($this->subscriberDefinittions);
            $this->subscriberDefinittions = [];
        }
    }

    protected function initSubscribers($subscriberDefinition)
    {
        foreach ($subscriberDefinition as $index => $subscriberDefinition) {
            $subscriberInstance = ClassHelper::createObject($subscriberDefinition);
//        $subscriberInstance = ContainerHelper::getContainer()->get($subscriberDefinition);
            $this->eventDispatcher->addSubscriber($subscriberInstance);
        }
    }

    protected function getEventDispatcher(): EventDispatcherInterface
    {
        $this->initEvent();
        return $this->eventDispatcher;
    }

    public function addListener(string $eventName, $listener, int $priority = 0)
    {
        $this->getEventDispatcher()->addListener($eventName, $listener, $priority);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->getEventDispatcher()->addSubscriber($subscriber);
    }

    public function addSubscriberClass(string $subscriberDefinition)
    {
        $this->subscriberDefinittions[] = $subscriberDefinition;
    }
}