<?php

namespace ZnCore\Base\DotEnv\Domain\Exceptions;

use Throwable;

class DotEnvNotFoundException extends \RuntimeException
{

    public function __construct($message = "Not found DotEnv value", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}