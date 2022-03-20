<?php

namespace ZnCore\Base\Libs\Event\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
//use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Helpers\ClassHelper;

trait EventDispatcherTrait
{

    /** @var EventDispatcher */
    private $eventDispatcher;

    //private $subscriberDefinittions = [];

    public function subscribes(): array
    {
        return [];
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    protected function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->initEventDispatcher();
    }

    /**
     * @return EventDispatcherInterface | \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        if (!isset($this->eventDispatcher)) {
            $eventDispatcher = new EventDispatcher();
            $this->setEventDispatcher($eventDispatcher);
        }
        return $this->eventDispatcher;
    }

    private function initEventDispatcher(): void
    {
        foreach ($this->subscribes() as $subscriberDefinition) {
            $subscriberInstance = $this->forgeSubscriberInstance($subscriberDefinition);
            $this->eventDispatcher->addSubscriber($subscriberInstance);
        }
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
            $subscriberInstance = ClassHelper::createObject($subscriberDefinition);
        }
        return $subscriberInstance;
    }

    /*protected function initSubscribersFromDefinitions(): void
    {
        if (empty($this->subscriberDefinittions)) {
            return;
        }
        $this->initSubscribers($this->subscriberDefinittions);
        $this->subscriberDefinittions = [];
    }

    protected function initSubscribers(array $subscriberDefinition): void
    {
        foreach ($subscriberDefinition as $subscriberDefinition) {
            $this->addSubscriber($subscriberDefinition);
        }
    }*/

    /*public function addListener(string $eventName, $listener, int $priority = 0)
    {
        $this->getEventDispatcher()->addListener($eventName, $listener, $priority);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->getEventDispatcher()->addSubscriber($subscriber);
    }

    public function addSubscriberClass(string $subscriberDefinition): void
    {
        $this->subscriberDefinittions[] = $subscriberDefinition;
    }*/

    /*protected function getED(): EventDispatcherInterface {
        if (!isset($this->eventDispatcher)) {
            $this->eventDispatcher = new EventDispatcher();
        }
        return $this->eventDispatcher;
    }*/
}
