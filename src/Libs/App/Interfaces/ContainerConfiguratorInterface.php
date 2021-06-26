<?php

namespace ZnCore\Base\Libs\App\Interfaces;

interface ContainerConfiguratorInterface
{

    public function singleton($abstract, $concrete): void;

    public function bind($abstract, $concrete, bool $shared = false): void;
}