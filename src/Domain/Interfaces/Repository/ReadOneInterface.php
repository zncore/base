<?php

namespace ZnCore\Base\Domain\Interfaces\Repository;

use ZnCore\Base\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Base\Domain\Libs\Query;
use ZnCore\Base\Exceptions\NotFoundException;

interface ReadOneInterface
{

    /**
     * @param $id
     * @param Query|null $query
     * @return EntityIdInterface | object
     * @throws NotFoundException
     */
    public function oneById($id, Query $query = null): EntityIdInterface;

}