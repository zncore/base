<?php

namespace ZnCore\Base\Libs\Repository\Mappers;

use ZnCore\Base\Libs\Repository\Interfaces\MapperInterface;

class JsonMapper implements MapperInterface
{

    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function encode($data)
    {
        foreach ($this->attributes as $attribute) {
            $data[$attribute] = json_encode($data[$attribute], JSON_UNESCAPED_UNICODE);
        }
        return $data;
    }

    public function decode($row)
    {
        foreach ($this->attributes as $attribute) {
            $value = $row[$attribute] ?? null;
            if ($value) {
                $row[$attribute] = json_decode($row[$attribute], JSON_OBJECT_AS_ARRAY);
            }
        }
        return $row;
    }
}
