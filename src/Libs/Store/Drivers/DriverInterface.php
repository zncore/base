<?php

namespace ZnCore\Base\Libs\Store\Drivers;

interface DriverInterface
{

    public function decode($content);

    public function encode($data);

}