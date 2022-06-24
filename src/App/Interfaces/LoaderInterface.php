<?php

namespace ZnCore\Base\App\Interfaces;

interface LoaderInterface
{

    public function loadMainConfig(string $appName): void;
}