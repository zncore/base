<?php

namespace ZnCore\Base\Libs\Service\Interfaces;

use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Libs\Query\Entities\Query;

interface FindOneInterface
{

    /**
     * @param $id
     * @param Query|null $query
     * @return object|EntityIdInterface
     * @throws NotFoundException
     */
    public function oneById($id, Query $query = null): EntityIdInterface;

}