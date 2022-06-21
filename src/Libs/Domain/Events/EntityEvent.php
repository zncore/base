<?php

namespace ZnCore\Base\Libs\Domain\Events;

use Symfony\Contracts\EventDispatcher\Event;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Base\Libs\EventDispatcher\Traits\EventSkipHandleTrait;

class EntityEvent extends Event
{

    use EventSkipHandleTrait;

    private $entity;

    public function __construct(object $entity)
    {
        $this->entity = $entity;
    }

    public function getEntity(): object
    {
        return $this->entity;
    }
}
