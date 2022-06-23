<?php

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Contracts\Cache\CacheInterface;

return [
    'singletons' => [
        LoggerInterface::class => NullLogger::class,
        AdapterInterface::class => ArrayAdapter::class,
        CacheInterface::class => AdapterInterface::class,
    ],
];
