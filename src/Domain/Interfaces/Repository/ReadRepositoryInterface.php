<?php

namespace ZnCore\Base\Domain\Interfaces\Repository;

use ZnCore\Base\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Domain\Interfaces\ReadAllInterface;

interface ReadRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, ReadOneInterface, RelationConfigInterface
{


}