<?php

namespace ZnCore\Base\Libs\Repository\Mappers;

use ZnCore\Base\Libs\Repository\Interfaces\MapperInterface;

class BinaryMapper implements MapperInterface
{

    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function encode($data)
    {
        foreach ($this->attributes as $attribute) {
            $data[$attribute] = base64_encode($data[$attribute]);
        }
        return $data;
    }

    public function decode($row)
    {
        foreach ($this->attributes as $attribute) {
            $value = $row[$attribute] ?? null;
            if ($value) {
                $row[$attribute] = base64_decode($row[$attribute]);
            }
        }
        return $row;
    }
}
