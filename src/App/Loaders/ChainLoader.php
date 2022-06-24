<?php

namespace ZnCore\Base\App\Loaders;

use Psr\Container\ContainerInterface;
use ZnCore\Base\App\Enums\KernelEventEnum;
use ZnCore\Base\App\Interfaces\LoaderInterface;
use ZnCore\Base\Container\Traits\ContainerAttributeTrait;

class ChainLoader implements LoaderInterface
{

    use ContainerAttributeTrait;

    protected $loaders;

    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    public function loadMainConfig(string $appName): void
    {
        if ($this->loaders) {
            foreach ($this->loaders as $loader) {
                $loader->loadMainConfig($appName);
            }
        }
    }

    public function setLoader(LoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }
}
