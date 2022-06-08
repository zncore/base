<?php

namespace ZnCore\Base\Libs\App\Interfaces;

interface ConfigManagerInterface
{

    public function set(string $name, $value): void;

    public function get(string $name, $defaultValue = null);
}