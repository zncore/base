<?php

namespace ZnCore\Base\Libs\Event\Traits;

use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;

trait EventSkipHandleTrait
{

    private $skipHandle = false;

    public function isSkipHandle(): bool
    {
        return $this->skipHandle;
    }

    public function skipHandle(): void
    {
        $this->skipHandle = true;
    }
}
