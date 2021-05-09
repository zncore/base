<?php

namespace ZnCore\Base\Libs\App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use ZnCore\Domain\Traits\Event\EventSkipHandleTrait;

class ConstructKernelEvent extends Event
{

    use EventSkipHandleTrait;

    private $appName;
    private $env;

    public function __construct(string $appName, array $env)
    {
        $this->appName = $appName;
        $this->env = $env;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    /*public function setAppName(string $appName): void
    {
        $this->appName = $appName;
    }*/

    public function getEnv(): array
    {
        return $this->env;
    }

    /*public function setEnv(array $env): void
    {
        $this->env = $env;
    }*/
}
