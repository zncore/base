<?php

namespace ZnCore\Base\SoftDelete\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Status\Enums\StatusEnum;
use ZnCore\Domain\Query\Entities\Where;
use ZnCore\Domain\Domain\Enums\EventEnum;
use ZnCore\Domain\Query\Enums\OperatorEnum;
use ZnCore\Domain\Domain\Events\EntityEvent;
use ZnCore\Domain\Domain\Events\QueryEvent;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\EntityManager\Traits\EntityManagerAwareTrait;

class SoftDeleteSubscriber implements EventSubscriberInterface
{

    use EntityManagerAwareTrait;

    public $disableStatusId = StatusEnum::DELETED;
//    public $enableStatusId = StatusEnum::ENABLED;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_DELETE_ENTITY => 'onBeforeDelete',
            EventEnum::BEFORE_FORGE_QUERY => 'onForgeQuery',
        ];
    }

    public function onBeforeDelete(EntityEvent $event)
    {
        $entity = $event->getEntity();
        if (method_exists($entity, 'delete')) {
            $entity->delete();
        } else {
            $entity->setStatusId($this->disableStatusId);
        }
        $this->getEntityManager()->persist($entity);
        $event->skipHandle();
    }

    public function onForgeQuery(QueryEvent $event)
    {
        if($event->getQuery()->getWhere()) {
            foreach ($event->getQuery()->getWhere() as $where) {
                /** @var Where $where */
                if($where->column == 'status_id') {
                    return;
                }
            }
        }
        $event->getQuery()->where('status_id', $this->disableStatusId, OperatorEnum::NOT_EQUAL);
    }
}
