<?php

namespace ZnCore\Base\Helpers\Types;

throw new \ZnCore\Base\Exceptions\DeprecatedException\DeprecatedException;

class StringType extends BaseType
{

    protected function _isValid($value, $params = null)
    {
        return is_string($value) || is_numeric($value);
    }

    public function normalizeValue($value, $params = null)
    {
        $value = strval($value);
        return $value;
    }
}