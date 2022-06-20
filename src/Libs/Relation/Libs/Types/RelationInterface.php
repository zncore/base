<?php

namespace ZnCore\Base\Libs\Relation\Libs\Types;

use Illuminate\Support\Collection;

interface RelationInterface
{

    public function run(Collection $collection);

}
