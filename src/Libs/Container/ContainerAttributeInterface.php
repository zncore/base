<?php

namespace ZnCore\Base\Libs\Container;

use Psr\Container\ContainerInterface;

interface ContainerAttributeInterface
{

    public function setContainer(ContainerInterface $container);
    public function getContainer(): ContainerInterface;
}
