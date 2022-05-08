<?php

namespace ZnCore\Base\Libs\Event\Traits;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Helpers\ClassHelper;

trait EventDispatcherTrait
{

    /** @var EventDispatcher */
    private $eventDispatcher;

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
}
