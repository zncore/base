<?php

namespace ZnCore\Base\App\Interfaces;

use ZnCore\Base\Container\Interfaces\ContainerAttributeInterface;

interface LoaderInterface //extends ContainerAttributeInterface
{

//    public function bootstrapApp(string $appName);
    public function loadMainConfig(string $appName): array;
}