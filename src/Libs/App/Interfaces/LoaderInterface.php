<?php

namespace ZnCore\Base\Libs\App\Interfaces;

use ZnCore\Base\Libs\Container\Interfaces\ContainerAttributeInterface;

interface LoaderInterface //extends ContainerAttributeInterface
{

//    public function bootstrapApp(string $appName);
    public function loadMainConfig(string $appName): array;
}