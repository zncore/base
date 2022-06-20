<?php

namespace ZnCore\Base\Libs\Repository\Base;

use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\Repository\Interfaces\RepositoryInterface;
use ZnCore\Base\Libs\EntityManager\Traits\EntityManagerAwareTrait;

abstract class BaseRepository implements RepositoryInterface
{

    use EntityManagerAwareTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }
}
