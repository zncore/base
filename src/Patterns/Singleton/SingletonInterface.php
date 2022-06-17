<?php

namespace ZnCore\Base\Patterns\Singleton;

interface SingletonInterface
{

    public static function getInstance(): self;

}