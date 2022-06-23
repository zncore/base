<?php

namespace ZnCore\Base\SoftDelete\Traits\Service;

use ZnCore\Base\Status\Enums\StatusEnum;

trait SoftRestoreTrait
{

    public function restoreById($id)
    {
        $entity = $this->oneById($id);
        $entity->restore();
        $this->getRepository()->update($entity);
        return true;
    }
}
