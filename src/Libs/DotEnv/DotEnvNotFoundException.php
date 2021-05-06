<?php

namespace ZnCore\Base\Libs\DotEnv;

use Throwable;
use ZnCore\Base\Exceptions\NotFoundException;

class DotEnvNotFoundException extends NotFoundException
{

    public function __construct($message = "Not found DotEnv value", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}