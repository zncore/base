<?php

namespace ZnCore\Base\Traits\MagicAttribute;

use ZnCore\Base\Helpers\DeprecateHelper;

DeprecateHelper::hardThrow();

trait MagicAttributeTrait
{

    use MagicGetterTrait;
    use MagicSetterTrait;

}
