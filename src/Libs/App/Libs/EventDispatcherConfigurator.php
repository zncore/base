<?php

namespace ZnCore\Base\Libs\App\Libs;

use Psr\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;

class EventDispatcherConfigurator
{

    use EventDispatcherTrait;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->setEventDispatcher($eventDispatcher);
    }
}
