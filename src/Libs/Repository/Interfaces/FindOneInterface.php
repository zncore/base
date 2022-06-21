<?php

namespace ZnCore\Base\Libs\Repository\Interfaces;

use ZnCore\Base\Exceptions\InvalidMethodParameterException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Libs\Query\Entities\Query;

interface FindOneInterface
{

    /**
     * @param $id
     * @param Query|null $query
     * @return EntityIdInterface | object
     * @throws NotFoundException
     * @throws InvalidMethodParameterException
     */
    public function oneById($id, Query $query = null): EntityIdInterface;

}