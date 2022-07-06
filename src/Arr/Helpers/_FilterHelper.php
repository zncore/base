<?php

namespace ZnCore\Base\Arr\Helpers;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Collection\Libs\Collection;
use ZnCore\Entity\Helpers\CollectionHelper;
use ZnCore\Domain\Query\Entities\Query;
use ZnCore\Domain\Query\Entities\Where;

class FilterHelper
{

    public static function filterItems(array $items, Query $query): array
    {
        $collection = new Collection($items);
        /** @var Where[] $whereArray */
        $whereArray = $query->getParam(Query::WHERE_NEW);
        if ($whereArray) {
            $collection = self::filterItemsByCondition($collection, $whereArray);
        }
        return $collection->toArray();
    }

    private static function filterItemsByCondition(Enumerable $collection, array $whereArray): Enumerable
    {
        foreach ($whereArray as $where) {
            $values = ArrayHelper::toArray($where->value);
            $resultCollection = new Collection();
            foreach ($values as $value) {

                /*$operators = [
                    OperatorEnum::EQUAL => Comparison::EQ,
                ];*/

                $expr = new Comparison($where->column, $where->operator, $value);
                $criteria = new Criteria();
                $criteria->andWhere($expr);
                $filteredCollection = $collection->matching($criteria);

//                $filteredCollection = $collection->where($where->column, $where->operator, $value);
                CollectionHelper::appendCollection($resultCollection, $filteredCollection);

//                $resultCollection = $resultCollection->concat($filteredCollection);
                dump($where, $collection);
            }
            $collection = $resultCollection;
        }
        return $collection;
    }
}
