<?php

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

return [
    'definitions' => [],
    'singletons' => [
        LoggerInterface::class => NullLogger::class,
    ],
];