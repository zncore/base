<?php

namespace ZnCore\Base\Libs\Store\Drivers;

interface DriverInterface1
{

    public function decode($content);

    public function encode($data);

}