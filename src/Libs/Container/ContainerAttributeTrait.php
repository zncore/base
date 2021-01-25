<?php

namespace ZnCore\Base\Libs\Container;

use Psr\Container\ContainerInterface;

trait ContainerAttributeTrait
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
