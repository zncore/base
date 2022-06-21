<?php

namespace ZnCore\Base\Libs\Domain\Interfaces;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\Query\Entities\Query;

interface FindAllInterface
{

    /**
     * @param Query|null $query
     * @return Collection|array
     */
    public function all(Query $query = null);

}
