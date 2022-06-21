<?php

namespace ZnCore\Base\Libs\Service\Subscribes;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Exceptions\ReadOnlyException;
use ZnCore\Base\Libs\Domain\Enums\EventEnum;
use ZnCore\Base\Libs\Domain\Events\EntityEvent;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\EntityManager\Traits\EntityManagerAwareTrait;

class ReadOnlyServiceSubscriber implements EventSubscriberInterface
{

    use EntityManagerAwareTrait;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_CREATE_ENTITY => 'onBefore',
            EventEnum::BEFORE_UPDATE_ENTITY => 'onBefore',
            EventEnum::BEFORE_DELETE_ENTITY => 'onBefore',
        ];
    }

    public function onBefore(EntityEvent $event)
    {
        throw new ReadOnlyException('Service readonly');
    }
}
