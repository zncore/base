<?php

namespace ZnCore\Base\Helpers\Types;

class ArrayType extends BaseType
{

    protected function _isValid($value, $params = null)
    {
        return is_array($value);
    }

    public function normalizeValue($value, $params = null)
    {
        return $value;
    }
}