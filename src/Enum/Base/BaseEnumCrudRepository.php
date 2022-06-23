<?php

namespace ZnCore\Base\Enum\Base;

use ZnCore\Base\Enum\Helpers\EnumHelper;
use ZnCore\Base\Arr\Base\BaseArrayCrudRepository;

abstract class BaseEnumCrudRepository extends BaseArrayCrudRepository
{

    abstract public function enumClass(): string;

    protected function getItems(): array
    {
        return EnumHelper::getItems($this->enumClass());
    }
}
