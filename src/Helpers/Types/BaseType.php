<?php

namespace ZnCore\Base\Helpers\Types;

use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Helpers\ClassHelper;

throw new \ZnCore\Base\Exceptions\DeprecatedException\DeprecatedException;

abstract class BaseType
{

    abstract protected function _isValid($value, $params = null);

    abstract public function normalizeValue($value, $params = null);

    public function validate($value, $params = null)
    {
        if ( ! $this->isValid($value, $params)) {
            $class = ClassHelper::getClassOfClassName(static::class);
            throw new InvalidArgumentException('Value "' . $value . '" not valid of "' . $class . '"!');
        }
    }

    public function isValid($value, $params = null)
    {
        if ($value === null) {
            return true;
        }
        return $this->_isValid($value, $params);
    }
}