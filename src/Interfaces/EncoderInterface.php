<?php

namespace ZnCore\Base\Interfaces;

interface EncoderInterface
{

    public function encode($data);

    public function decode($encodedData);

}
