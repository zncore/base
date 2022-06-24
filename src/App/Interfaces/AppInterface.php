<?php

namespace ZnCore\Base\App\Interfaces;

interface AppInterface
{

    public function appName(): string;

    public function init(): void;
}
