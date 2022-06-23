<?php

namespace ZnCore\Base\Libs\SoftDelete\Traits\Entity;

use ZnCore\Contract\User\Exceptions\UnauthorizedException;
use ZnCore\Base\Libs\Status\Enums\StatusEnum;

/**
 * @todo: перенести в отдельный пакет
 */
trait SoftDeleteEntityTrait
{

    abstract public function setStatusId(int $statusId): void;

    public function delete(): void
    {
        if($this->getStatusId() == StatusEnum::DELETED) {
            throw new \DomainException('The entry has already been deleted');
        }
        $this->statusId = StatusEnum::DELETED;
    }
}
