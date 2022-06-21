<?php

namespace ZnCore\Base\Libs\DataProvider\Interfaces;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\Query\Entities\Query;

/**
 * Провайдер данных
 * 
 * Используется при выборке коллекции сущностей и параметров пагинации
 */
interface DataProviderInterface
{

    /**
     * Получить коллекцию сущностей
     * @return Collection
     */
    public function getCollection(): Collection;

    /**
     * Получить общее колличество записей в хранилище
     * @return int
     */
    public function getTotalCount(): int;
}