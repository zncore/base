<?php

namespace ZnCore\Base\Domain\Entities\relation;

use ZnCore\Base\Domain\Enums\RelationEnum;

/**
 * Class RelationEntity
 *
 * @package ZnCore\Base\Domain\Entities\relation
 *
 * @property $type
 * @property $field
 * @property ForeignEntity $foreign
 * @property ForeignViaEntity $via
 * @property $callback
 */
class RelationEntity
{

    public $type;
    public $field;
    public $foreign;
    public $via;
    public $callback;

    public function fieldType()
    {
        return [
            'foreign' => ForeignEntity::class,
            'via' => ForeignViaEntity::class,
        ];
    }

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'in', 'range' => RelationEnum::values()],
        ];
    }

}
