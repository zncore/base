<?php

namespace ZnCore\Base\Libs\SoftDelete\Traits\Service;

use ZnCore\Base\Libs\Status\Enums\StatusEnum;

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
