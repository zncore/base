<?php

namespace ZnCore\Base\Libs\Arr\Base;

use ZnCore\Base\Libs\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Base\Libs\Arr\Traits\ArrayCrudRepositoryTrait;

abstract class BaseArrayCrudRepository extends BaseRepository implements CrudRepositoryInterface
{

    use ArrayCrudRepositoryTrait;
}
