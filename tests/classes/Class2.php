<?php

namespace App1;

class Class2
{

    private $class1;

    public function __construct(Class1 $class1)
    {
        $this->class1 = $class1;
    }

    public function plus(int $a, int $b): int
    {
        return $this->class1->plus($a, $b);
    }

    public function method1(Class1 $class1, int $a, int $b): int
    {
        return $class1->plus($a, $b);
    }
}