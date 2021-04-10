<?php

namespace ZnCore\Base\Exceptions;

use Exception;
use ZnCore\Base\Helpers\DeprecateHelper;

DeprecateHelper::getStrictMode();

/**
 * Class UnauthorizedException
 * @package ZnCore\Base\Exceptions
 * @deprecated
 * @see \ZnBundle\User\Domain\Exceptions\UnauthorizedException
 */
class UnauthorizedException extends Exception
{

}
