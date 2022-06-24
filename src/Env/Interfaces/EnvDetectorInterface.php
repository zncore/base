<?php

namespace ZnCore\Base\Env\Interfaces;

interface EnvDetectorInterface
{

    public function isMatch(): bool;

    public function isTest(): bool;
}
