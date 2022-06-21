<?php

namespace ZnCore\Base\Libs\EntityManager\Interfaces;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Libs\Entity\Interfaces\UniqueInterface;
use ZnCore\Base\Libs\Repository\Interfaces\FindOneUniqueInterface;
use ZnCore\Base\Libs\Repository\Interfaces\RepositoryInterface;
use ZnCore\Base\Libs\Query\Entities\Query;

interface EntityManagerInterface extends TransactionInterface, FindOneUniqueInterface
{

    public function getRepository(string $entityClass): RepositoryInterface;

    public function loadEntityRelations(object $entityOrCollection, array $with): void;
//    public function loadEntityRelations(string $entityClass, object $entity, array $with);

    /*public function all(string $entityClass, Query $query = null): Collection;

    public function count(string $entityClass, Query $query = null): int;

    public function one(string $entityClass, Query $query = null): EntityIdInterface;

    public function oneById(string $entityClass, $id, Query $query = null): EntityIdInterface;*/

//    public function oneByUnique(UniqueInterface $entity): ?EntityIdInterface;

    public function remove(EntityIdInterface $entity): void;

    public function persist(EntityIdInterface $entity): void;

    public function insert(EntityIdInterface $entity): void;

    public function update(EntityIdInterface $entity): void;

//    public function getRepositoryByClass(string $class): RepositoryInterface;

    public function createEntity(string $entityClassName, array $attributes = []): object;

    public function createEntityCollection(string $entityClassName, array $items): Collection;

}
