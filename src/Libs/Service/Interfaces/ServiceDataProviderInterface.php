<?php

namespace ZnCore\Base\Libs\Service\Interfaces;

use ZnCore\Base\Libs\DataProvider\Libs\DataProvider;
use ZnCore\Base\Libs\Query\Entities\Query;

interface ServiceDataProviderInterface
{

    public function getDataProvider(Query $query = null): DataProvider;

}