<?php

namespace ZnCore\Base\Libs\Repository\Interfaces;

use ZnCore\Base\Exceptions\InvalidMethodParameterException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Base\Libs\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Libs\Entity\Interfaces\UniqueInterface;

interface FindOneUniqueInterface
{

    /**
     * @param UniqueInterface $entity
     * @return EntityIdInterface | object
     * @throws NotFoundException
     * @throws InvalidMethodParameterException
     */
    public function oneByUnique(UniqueInterface $entity): EntityIdInterface;

}