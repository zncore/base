<?php

namespace App1;

class Class1
{
    private $class0;

    public function __construct(Class0 $class0)
    {
        $this->class0 = $class0;
    }

    public function plus(int $a, int $b): int
    {
        return $this->class0->plus($a, $b);
    }
}
