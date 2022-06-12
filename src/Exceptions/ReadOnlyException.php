<?php

namespace ZnCore\Base\Exceptions;

use Exception;

/**
 * Значение только для чтения
 * 
 * Обычно это исключение вызывается при попытке записи значения, предназначенного только для чтения.
 */
class ReadOnlyException extends Exception
{

}
