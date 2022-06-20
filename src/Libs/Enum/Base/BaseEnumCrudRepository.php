<?php

namespace ZnCore\Base\Libs\Enum\Base;

use ZnCore\Base\Libs\Enum\Helpers\EnumHelper;
use ZnCore\Base\Libs\Arr\Base\BaseArrayCrudRepository;

abstract class BaseEnumCrudRepository extends BaseArrayCrudRepository
{

    abstract public function enumClass(): string;

    protected function getItems(): array
    {
        return EnumHelper::getItems($this->enumClass());
    }
}
