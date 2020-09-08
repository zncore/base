<?php

namespace ZnCore\Base\Domain\Enums;

use ZnCore\Base\Domain\Base\BaseEnum;

class RelationEnum extends BaseEnum
{

    const ONE = 'one';
    const MANY = 'many';
    const MANY_TO_MANY = 'many-to-many';
    const CALLBACK = 'callback';

}
