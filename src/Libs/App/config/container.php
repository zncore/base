<?php

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

return [
    'singletons' => [
        LoggerInterface::class => NullLogger::class,
    ],
];