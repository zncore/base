<?php

namespace ZnCore\Base\Domain\Entities\relation;

use ZnCore\Base\Domain\Enums\RelationClassTypeEnum;

/**
 * Class BaseForeignEntity
 *
 * @package ZnCore\Base\Domain\Entities\relation
 *
 * @property $id
 * @property $domain
 * @property $name
 * @property $model
 * @property $classType
 */
abstract class BaseForeignEntity
{

    public $id;
    public $domain;
    public $name;
    public $model;
    public $classType = RelationClassTypeEnum::REPOSITORY;

    public function rules()
    {
        return [
            [['classType'], 'in', 'range' => RelationClassTypeEnum::values()],
        ];
    }

    public function setId($id)
    {
        list($this->domain, $this->name) = explode('.', $id);
    }

    public function getId()
    {

    }

}