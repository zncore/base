<?php

use Psr\Container\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\SymfonyTranslation\Libs\Translator;

$defaultLang = 'ru';

return [
    'singletons' => [
        TranslatorInterface::class => function (ContainerInterface $container) use($defaultLang) {
            return $container->make(Translator::class, [
                'locale' => 'ru',
                'bundleName' => 'symfony',
            ]);
            //return new Translator('ru', 'symfony');
        },
    ],
];
