<?php

namespace ZnCore\Base\Domain\Interfaces;

use ZnCore\Base\Domain\Libs\DataProvider;
use ZnCore\Base\Domain\Libs\Query;

interface DataProviderInterface
{

    public function getDataProvider(Query $query = null): DataProvider;

}