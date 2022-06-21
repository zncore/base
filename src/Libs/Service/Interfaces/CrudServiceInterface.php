<?php

namespace ZnCore\Base\Libs\Service\Interfaces;

use ZnCore\Base\Libs\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Libs\Domain\Interfaces\ReadAllInterface;

interface CrudServiceInterface extends ServiceDataProviderInterface, ServiceInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface, ModifyInterface
{


}