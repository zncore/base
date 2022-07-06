<?php

namespace ZnCore\Base\Arr\Helpers;

use ZnCore\Collection\Libs\Collection;
use ZnCore\Entity\Helpers\CollectionHelper;
use ZnCore\Domain\Query\Entities\Query;

class FilterHelper
{

    public static function filterItems(array $items, Query $query): array
    {
        $collection = new Collection($items);
        $collection = CollectionHelper::filterByQuery($collection, $query);
        return $collection->toArray();

//        return $collection->matching($criteria);


//        $collection = new Collection($items);
//        /** @var Where[] $whereArray */
////        $whereArray = $query->getParam(Query::WHERE_NEW);
//        $whereArray = $query->getWhere();
//        if ($whereArray) {
//            $collection = CollectionHelper::whereArr($collection, $whereArray);
////            $collection = self::filterItemsByCondition($collection, $whereArray);
//        }
//        return $collection->toArray();
    }

    /*private static function filterItemsByCondition(Enumerable $collection, array $whereArray): Collection
    {
        $collection = new \Illuminate\Support\Collection($collection->toArray());
        foreach ($whereArray as $where) {
            $values = ArrayHelper::toArray($where->value);
            $resultCollection = new \Illuminate\Support\Collection();
            foreach ($values as $value) {
                $filteredCollection = $collection->where($where->column, $where->operator, $value);
                $resultCollection = $resultCollection->concat($filteredCollection);
            }
            $collection = $resultCollection;
        }

        return new Collection($collection->toArray());
//        return $collection;
    }*/
}
