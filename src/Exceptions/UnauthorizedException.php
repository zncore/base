<?php

namespace ZnCore\Base\Exceptions;

use Exception;
use ZnCore\Base\Helpers\DeprecateHelper;

DeprecateHelper::getStrictMode();

/**
 * Class UnauthorizedException
 * @package ZnCore\Base\Exceptions
 * @deprecated
 */
class UnauthorizedException extends Exception
{

}
