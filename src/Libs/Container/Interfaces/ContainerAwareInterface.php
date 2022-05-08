<?php

namespace ZnCore\Base\Libs\Container\Interfaces;

use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null);

}
