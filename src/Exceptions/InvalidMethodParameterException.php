<?php

namespace ZnCore\Base\Exceptions;

use Exception;

class InvalidMethodParameterException extends Exception
{

    private $parameterName;

    public function getParameterName(): ?string
    {
        return $this->parameterName;
    }

    public function setParameterName(string $parameterName): self
    {
        $this->parameterName = $parameterName;
        return $this;
    }
}
