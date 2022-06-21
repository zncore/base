<?php

namespace ZnCore\Base\Libs\Repository\Mappers;

use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Libs\Repository\Interfaces\MapperInterface;

class TimeMapper implements MapperInterface
{

    public $format = 'Y-m-d H:i:s';
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function encode($data)
    {
        foreach ($this->attributes as $attribute) {
//            $data[$attribute] = $time->format($this->format);
//            $data[$attribute] = json_encode($data[$attribute], JSON_UNESCAPED_UNICODE);
        }
        return $data;
    }

    public function decode($row)
    {
        foreach ($this->attributes as $attribute) {
            $attribute = Inflector::underscore($attribute);
            $value = $row[$attribute];
            if ($value) {
                $row[$attribute] = new \DateTime($value);
            }
        }
        return $row;
    }
}
