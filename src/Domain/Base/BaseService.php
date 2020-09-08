<?php

namespace ZnCore\Base\Domain\Base;

use ZnCore\Base\Domain\Helpers\EntityHelper;
use ZnCore\Base\Domain\Interfaces\Traits\CreateEntityInterface;
use ZnCore\Base\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Helpers\InstanceHelper;

abstract class BaseService implements GetEntityClassInterface, CreateEntityInterface
{

    protected $repository;

    /**
     * @return GetEntityClassInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    protected function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getEntityClass(): string
    {
        return $this->getRepository()->getEntityClass();
    }

    public function createEntity(array $attributes = [])
    {
        $entityClass = $this->getEntityClass();
        $entityInstance = EntityHelper::createEntity($entityClass, $attributes);
        return $entityInstance;
    }

}