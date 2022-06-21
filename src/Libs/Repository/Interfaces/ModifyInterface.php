<?php

namespace ZnCore\Base\Libs\Repository\Interfaces;

use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Exceptions\NotFoundException;

interface ModifyInterface
{
    /**
     * @param EntityIdInterface | object $entity
     * @throws UnprocessibleEntityException
     */
    public function create(EntityIdInterface $entity);

    /*
     * @param EntityIdInterface | object $entity
     * @throws UnprocessibleEntityException
     */
    //public function persist(EntityIdInterface $entity);

    /**
     * @param EntityIdInterface | object $entity
     * @throws NotFoundException
     * @throws UnprocessibleEntityException
     */
    public function update(EntityIdInterface $entity);

    /*
     * @param int $id
     * @param array $data
     * @throws NotFoundException
     * @throws UnprocessibleEntityException
     */
    //public function updateById($id, $data);

    /**
     * @param int $id
     * @throws NotFoundException
     */
    public function deleteById($id);

    public function deleteByCondition(array $condition);

}