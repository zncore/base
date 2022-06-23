<?php

namespace ZnCore\Base\Store\Drivers;

interface DriverInterface
{

    public function decode($content);

    public function encode($data);

}