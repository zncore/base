<?php

namespace ZnCore\Base\Libs\ArrayTools\Filters\Iterator;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Libs\Query;
use ZnCore\Base\Libs\Scenario\Base\BaseScenario;

class Sort extends BaseScenario
{

    public $query;

    public function run()
    {
        $collection = $this->getData();
        $collection = $this->filterSort($collection, $this->query);
        $this->setData($collection);
    }

    protected function filterSort(Array $collection, Query $query)
    {
        $orders = $query->getParam('order');
        if (empty($orders)) {
            return $collection;
        }
        ArrayHelper::multisort($collection, array_keys($orders), array_values($orders));
        return $collection;
    }
}
