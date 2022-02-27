<?php

namespace ZnCore\Base\Entities;

class DirectoryEntity extends BaseEntity
{

    protected $items = null;

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }
}
