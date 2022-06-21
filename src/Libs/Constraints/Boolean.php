<?php

namespace ZnCore\Base\Libs\Constraints;

use Symfony\Component\Validator\Constraint;

class Boolean extends Constraint
{

    public $message = 'The item id "{{ string }}" does not belong to the book "{{ bookName }}"';
    public $bookName;
}