<?php

namespace ZnCore\Base\Domain\Strategies\join\handlers;

use Illuminate\Support\Collection;
use ZnCore\Base\Domain\Dto\WithDto;
use ZnCore\Base\Domain\Entities\relation\RelationEntity;

class Callback extends Base implements HandlerInterface
{

    public function join(Collection $collection, RelationEntity $relationEntity)
    {
        call_user_func_array($relationEntity->callback, [$collection]);

    }

    public function load(object $entity, WithDto $w, $relCollection): RelationEntity
    {

    }

}