<?php

namespace ZnCore\Base\Container\Interfaces;

use Psr\Container\ContainerInterface;

interface ContainerAttributeInterface
{

    public function setContainer(ContainerInterface $container);
    public function getContainer(): ContainerInterface;
}