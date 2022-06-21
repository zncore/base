<?php

namespace ZnCore\Base\Libs\Author\Subscribes;

use App\News\Domain\Entities\CommentEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Contract\User\Exceptions\UnauthorizedException;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Base\Libs\Domain\Enums\EventEnum;
use ZnCore\Base\Libs\Domain\Events\EntityEvent;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;

/**
 * @todo: перенести в отдельный пакет
 */
class SetAuthorIdSubscriber implements EventSubscriberInterface
{

    private $authService;
    private $attribute;

    public function __construct(
        AuthServiceInterface $authService
    )
    {
        $this->authService = $authService;
    }

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_CREATE_ENTITY => 'onCreateComment'
        ];
    }

    public function onCreateComment(EntityEvent $event)
    {
        /** @var CommentEntity $entity */
        $entity = $event->getEntity();
        $identityId = $this->authService->getIdentity()->getId();
        EntityHelper::setAttribute($entity, $this->attribute, $identityId);
        try {

        } catch (UnauthorizedException $e) {
        }
    }
}