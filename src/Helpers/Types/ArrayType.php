<?php

namespace ZnCore\Base\Helpers\Types;

throw new \ZnCore\Base\Exceptions\DeprecatedException\DeprecatedException;

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