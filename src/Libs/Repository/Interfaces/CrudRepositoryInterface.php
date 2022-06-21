<?php

namespace ZnCore\Base\Libs\Repository\Interfaces;

use ZnCore\Base\Libs\Repository\Interfaces\RepositoryInterface;
use ZnCore\Base\Libs\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Libs\Domain\Interfaces\ReadAllInterface;

interface CrudRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, ReadOneInterface, ModifyInterface//, RelationConfigInterface
{

}
