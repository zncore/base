<?php

namespace ZnCore\Base\Exceptions;

use Exception;

/**
 * Заглушка для ненужных методов интерфейса
 * 
 * Например, реализуем CRUD-интерфейс репозитория, 
 * но метод delete нам не нужен, мы реализуем сам метод, 
 * а внутри ввызываем это исключение.
 */
class NotImplementedMethodException extends Exception
{

}
