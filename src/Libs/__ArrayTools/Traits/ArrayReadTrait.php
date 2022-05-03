<?php

namespace ZnCore\Base\Libs\ArrayTools\Traits;

use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\ArrayTools\Helpers\ArrayIterator;
use ZnCore\Domain\Libs\Alias;
use ZnCore\Domain\Libs\Query;

/**
 * Trait ArrayReadTrait
 *
 * @package ZnCore\Base\Libs\ArrayTools\Traits
 *
 * @property string $id
 * @property string $primaryKey
 * @property Domain $domain
 */
trait ArrayReadTrait
{

    abstract public function forgeEntity($data, $class = null);

    abstract protected function getCollection();

    /**
     * @return Alias
     */
    abstract public function getAlias();

    public function isExistsById($id)
    {
        try {
            $this->oneById($id);
            return true;
        } catch (NotFoundHttpException $e) {
            return false;
        }
    }

    /**
     * @param array|Query $condition
     *
     * @return bool
     */
    public function isExists($condition)
    {
        /** @var Query $query */
        $query = $this->prepareQuery();
        if (is_array($condition)) {
            $query->whereFromCondition($condition);
        } else {
            $query->where($this->primaryKey, $condition);
        }
        try {
            $this->one($query);
            return true;
        } catch (NotFoundHttpException $e) {
            return false;
        }
    }

    public function oneByUnique(array $uniqueCond, Query $query = null)
    {
        $query = Query::forge($query);
        $query->where($uniqueCond);
        $entity = $this->one($query);
        return $entity;
    }

    public function oneById($id, Query $query = null)
    {
        /** @var Query $query */
        $query = Query::forge($query);
        //$query->removeParam('where');
        $query->andWhere([$this->primaryKey => $id]);
        return $this->one($query);
    }

    public function one(Query $query = null)
    {
        /** @var Query $query */
        $query = $this->prepareQuery($query);
        if ( ! $query->hasParam('where') /*|| $query->getParam('where') == []*/) {
            throw new InvalidArgumentException('Where connot be empty!');
        };
        $query->limit(1);
        $collection = $this->all($query);
        if (empty($collection)) {
            $message = json_encode($query->getParam(Query::WHERE));
            throw new NotFoundHttpException(get_called_class() . PHP_EOL . ' Where: ' . $message);
        }
        $entity = ArrayHelper::first($collection);
        return $entity;
    }

    /*
     * @param Query|null $query
     *
     * @return array|mixed
     * @deprecated
     */
    /*public function allArray(Query $query = null)
    {
        $iterator = $this->getIterator();
        $array = $iterator->all($query);
        $array = $this->forgeEntity($array);
        return $array;
    }*/

    public function all(Query $query = null)
    {
        return $this->allWithRelation($query, 'allArray');
    }

    public function count(Query $query = null)
    {
        $query = Query::forge($query);
        $iterator = $this->getIterator();
        return $iterator->count($query);
    }

    private function getIterator()
    {
        $collection = $this->getCollection();
        $iterator = new ArrayIterator();
        $iterator->setCollection($collection);
        return $iterator;
    }

}