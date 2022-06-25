<?php

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use ZnCore\Base\Validation\Libs\Validators\ChainValidator;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Validation\Libs\Validators\ClassMetadataValidator;
use ZnLib\Components\DynamicEntity\Libs\Validators\DynamicEntityValidator;

/**
 * @todo перенести в компонент Null
 */
return [
    'singletons' => [
        LoggerInterface::class => NullLogger::class,
        AdapterInterface::class => ArrayAdapter::class,
        CacheInterface::class => AdapterInterface::class,
        ChainValidator::class => function(ContainerInterface $container) {
            /** @var ChainValidator $chainValidator */
            $chainValidator = new ChainValidator($container);
            $chainValidator->setValidators([
                ClassMetadataValidator::class,
                DynamicEntityValidator::class,
            ]);
            return $chainValidator;
        }
    ],
];
