<?php

namespace ZnCore\Base\Domain\Dto;

use ZnCore\Base\Domain\Libs\Query;
use ZnCore\Base\Domain\Entities\relation\RelationEntity;

class WithDto
{

    /**
     * @var Query
     */
    public $query;
    public $remain;
    public $remainOfRelation;
    public $relationName;

    /**
     * @var RelationEntity
     */
    public $relationConfig;
    public $passed;
    public $withParams;

}