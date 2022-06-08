<?php

namespace ZnCore\Base\Libs\Container\Traits;

use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    protected function ensureContainer(ContainerInterface $container = null): ContainerInterface
    {
        return $container ?: $this->container;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
