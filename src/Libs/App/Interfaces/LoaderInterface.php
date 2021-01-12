<?php

namespace ZnCore\Base\Libs\App\Interfaces;

interface LoaderInterface
{

    public function bootstrapApp(string $appName);
    public function loadMainConfig(string $appName): array;
}