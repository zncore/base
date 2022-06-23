<?php

namespace ZnCore\Base\SoftDelete\Traits\Service;

use ZnCore\Base\Status\Enums\StatusEnum;

trait SoftDeleteTrait
{

    public function deleteById($id)
    {
        $entity = $this->oneById($id);
        $entity->delete();
        $this->getRepository()->update($entity);
        return true;
    }
}
