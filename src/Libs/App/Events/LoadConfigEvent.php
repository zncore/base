<?php

namespace ZnCore\Base\Libs\App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\Container\Interfaces\ContainerAttributeInterface;
use ZnCore\Base\Libs\EventDispatcher\Traits\EventSkipHandleTrait;

class LoadConfigEvent extends Event
{

    use EventSkipHandleTrait;

    private $config;
    private $loader;

    public function __construct(LoaderInterface $loader, array $config)
    {
        $this->config = $config;
        $this->loader = $loader;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /*public function getKernel(): ContainerAttributeInterface
    {
        return $this->kernel;
    }*/
}
