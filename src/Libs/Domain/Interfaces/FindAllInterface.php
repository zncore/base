<?php

namespace ZnCore\Base\Libs\Domain\Interfaces;

use Illuminate\Support\Enumerable;
use ZnCore\Base\Libs\Query\Entities\Query;

interface FindAllInterface
{

    /**
     * @param Query|null $query
     * @return Enumerable|array
     */
    public function all(Query $query = null): Enumerable;

}
