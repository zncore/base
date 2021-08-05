<?php

namespace ZnCore\Base\Libs\App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use ZnCore\Contract\Kernel\Interfaces\KernelInterface;
use ZnCore\Domain\Traits\Event\EventSkipHandleTrait;

class LoadConfigEvent extends Event
{

    use EventSkipHandleTrait;

    private $config;
    private $kernel;

    public function __construct(KernelInterface $kernel, array $config)
    {
        $this->config = $config;
        $this->kernel = $kernel;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function getKernel(): KernelInterface
    {
        return $this->kernel;
    }
}
