<?php

namespace ZnCore\Base\Libs\Event\Traits;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Helpers\ClassHelper;

trait EventDispatcherTrait
{

    /** @var EventDispatcher */
    private $eventDispatcher;

    private $subscriberDefinittions = [];

    public function subscribes(): array
    {
        return [];
    }

    protected function initSubscribersFromDefinitions()
    {
        if (empty($this->subscriberDefinittions)) {
            return;
        }
        $this->initSubscribers($this->subscriberDefinittions);
        $this->subscriberDefinittions = [];
    }

    protected function initSubscribers($subscriberDefinition)
    {
        foreach ($subscriberDefinition as $index => $subscriberDefinition) {
            $subscriberInstance = ClassHelper::createObject($subscriberDefinition);
//        $subscriberInstance = ContainerHelper::getContainer()->get($subscriberDefinition);
            $this->eventDispatcher->addSubscriber($subscriberInstance);
        }
    }

    public function getEventDispatcher(): EventDispatcherInterface
    {
        if (!isset($this->eventDispatcher)) {
            $this->eventDispatcher = new EventDispatcher();
            $this->initSubscribers($this->subscribes());
        }
        $this->initSubscribersFromDefinitions();
        return $this->eventDispatcher;
    }

    /*public function addListener(string $eventName, $listener, int $priority = 0)
    {
        $this->getEventDispatcher()->addListener($eventName, $listener, $priority);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->getEventDispatcher()->addSubscriber($subscriber);
    }*/

    public function addSubscriberClass(string $subscriberDefinition)
    {
        $this->subscriberDefinittions[] = $subscriberDefinition;
    }
}