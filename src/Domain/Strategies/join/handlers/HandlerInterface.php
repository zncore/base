<?php

namespace ZnCore\Base\Domain\Strategies\join\handlers;

use Illuminate\Support\Collection;
use ZnCore\Base\Domain\Dto\WithDto;
use ZnCore\Base\Domain\Entities\relation\RelationEntity;

interface HandlerInterface
{

    public function join(Collection $collection, RelationEntity $relationEntity);

    public function load(object $entity, WithDto $w, $relCollection): RelationEntity;

}
