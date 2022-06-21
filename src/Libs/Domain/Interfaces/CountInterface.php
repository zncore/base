<?php

namespace ZnCore\Base\Libs\Domain\Interfaces;

use ZnCore\Base\Libs\Query\Entities\Query;

interface CountInterface
{

    public function count(Query $query = null): int;

}
