<?php

namespace ZnCore\Base\Libs\ArrayTools\Filters\Iterator;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Libs\Query;
use ZnCore\Base\Libs\Scenario\Base\BaseScenario;

class Where extends BaseScenario
{

    public $query;

    public function run()
    {
        $collection = $this->getData();
        $collection = $this->filterWhere($collection, $this->query);
        $this->setData($collection);
    }

    protected function filterWhere(Array $collection, Query $query)
    {
        $condition = [];
        $where = $query->getParam('where');
        if (empty($where)) {
            return $collection;
        }
        foreach ($where as $name => $value) {
            $key = 'where.' . $name;
            if ($query->hasParam($key)) {
                $condition[$name] = $query->getParam($key);
            }
        }
        $collection = ArrayHelper::findAll($collection, $condition);
        return $collection;
    }
}
