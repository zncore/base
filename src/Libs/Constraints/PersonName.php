<?php

namespace ZnCore\Base\Libs\Constraints;

use Symfony\Component\Validator\Constraint;

class PersonName extends Constraint
{

    public $message = 'The name "{{ value }}" must contain only letters';
}
