<?php

namespace ZnCore\Base\Libs\SoftDelete\Traits\Entity;

use ZnCore\Base\Libs\Status\Enums\StatusEnum;

/**
 * @todo: перенести в отдельный пакет
 */
trait SoftRestoreEntityTrait
{

    abstract public function setStatusId(int $statusId): void;

    public function restore(): void
    {
        if($this->getStatusId() == StatusEnum::ENABLED) {
            throw new \DomainException('The entry has already been restored');
        }
        $this->statusId = StatusEnum::ENABLED;
    }
}
