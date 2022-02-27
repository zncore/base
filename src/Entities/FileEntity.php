<?php

namespace ZnCore\Base\Entities;

class FileEntity extends BaseEntity
{

    protected $size = null;

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size): void
    {
        $this->size = $size;
    }
}
