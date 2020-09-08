<?php

namespace ZnCore\Base\Domain\Entities\relation;

/**
 * Class ForeignEntity
 *
 * @package ZnCore\Base\Domain\Entities\relation
 *
 * @property $field
 * @property $value
 */
class ForeignEntity extends BaseForeignEntity
{

    public $field = 'id';
    public $value;

}