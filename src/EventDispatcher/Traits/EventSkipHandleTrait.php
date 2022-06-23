<?php

namespace ZnCore\Base\EventDispatcher\Traits;

use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;

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
