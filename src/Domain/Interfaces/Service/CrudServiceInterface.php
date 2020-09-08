<?php

namespace ZnCore\Base\Domain\Interfaces\Service;

use ZnCore\Base\Domain\Interfaces\DataProviderInterface;
use ZnCore\Base\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Domain\Interfaces\ReadAllInterface;

interface CrudServiceInterface extends DataProviderInterface, ServiceInterface, GetEntityClassInterface, ReadAllInterface, ReadOneInterface, ModifyInterface
{


}