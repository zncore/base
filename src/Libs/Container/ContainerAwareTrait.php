<?php

namespace ZnCore\Base\Libs\Container;

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

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
