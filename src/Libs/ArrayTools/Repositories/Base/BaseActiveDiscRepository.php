<?php

namespace ZnCore\Base\Libs\ArrayTools\Repositories\Base;

use php7rails\domain\interfaces\repositories\CrudInterface;
use ZnCore\Base\Libs\ArrayTools\Traits\ArrayModifyTrait;
use ZnCore\Base\Libs\ArrayTools\Traits\ArrayReadTrait;

abstract class BaseActiveDiscRepository extends BaseDiscRepository implements CrudInterface
{

    use ArrayReadTrait;
    use ArrayModifyTrait;

}