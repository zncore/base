<?php

namespace ZnCore\Base\Libs\EntityManager\Traits;

use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;

trait EntityManagerAwareTrait
{

    private $entityManager;

    protected function hasEntityManager(): bool
    {
        return isset($this->entityManager);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
