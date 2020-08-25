<?php

namespace PhpLab\Core\Domain\Interfaces\Service;

use PhpLab\Core\Domain\Interfaces\Entity\EntityIdInterface;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Exceptions\NotFoundException;

interface ReadOneInterface
{

    /**
     * @param $id
     * @param Query|null $query
     * @return object|EntityIdInterface
     * @throws NotFoundException
     */
    public function oneById($id, Query $query = null);

}