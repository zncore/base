<?php

namespace ZnCore\Base\Exceptions;

use ZnCore\Base\Helpers\DeprecateHelper;

DeprecateHelper::softThrow();

/**
 * @deprecated
 * @see \ZnCore\Contract\User\Exceptions\UnauthorizedException
 */
class UnauthorizedException extends \ZnCore\Contract\User\Exceptions\UnauthorizedException
{

}
