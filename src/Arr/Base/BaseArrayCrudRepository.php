<?php

namespace ZnCore\Base\Arr\Base;

use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Base\Arr\Traits\ArrayCrudRepositoryTrait;

abstract class BaseArrayCrudRepository extends BaseRepository implements CrudRepositoryInterface
{

    use ArrayCrudRepositoryTrait;
}
