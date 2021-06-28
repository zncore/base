<?php

namespace ZnCore\Base\Libs\App\Base;

abstract class BaseBundle
{

    private $importList;

    public function deps(): array
    {
        return [];
    }

    public function getImportList(): array
    {
        return $this->importList;
    }

    public function __construct(array $importList = [])
    {
        $this->importList = $importList;
    }

    public function console(): array
    {
        return [];
    }

    public function container(): array
    {
        return [];
    }
}
