<?php

namespace ZnCore\Base\Libs\Entity\Subscribers;

use App\News\Domain\Entities\CommentEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Libs\Domain\Enums\EventEnum;
use ZnCore\Base\Libs\Domain\Events\EntityEvent;

/**
 * @todo: перенести в отдельный пакет
 */
class SetUpdatedAtSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
//            EventEnum::BEFORE_CREATE_ENTITY => 'onBeforePersist',
            EventEnum::BEFORE_UPDATE_ENTITY => 'onBeforePersist',
        ];
    }

    public function onBeforePersist(EntityEvent $event)
    {
        $entity = $event->getEntity();
        $entity->setUpdatedAt(new \DateTime());
    }
}