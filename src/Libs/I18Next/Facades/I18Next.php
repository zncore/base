<?php

namespace ZnCore\Base\Libs\I18Next\Facades;

use Psr\Container\ContainerInterface;
use Yii;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;

class I18Next
{

    private static $container;
    private static $service;

    public static function setContainer(ContainerInterface $container) {
        self::$container = $container;
        self::$service = self::$container->get(TranslationServiceInterface::class);
    }

    public static function getService(): TranslationServiceInterface {
        return self::$service;
    }

    public static function setService(TranslationServiceInterface $translationService) {
        self::$service = $translationService;
    }

    public static function t(string $bundleName, string $key, array $variables = [])
    {
        /** @var TranslationServiceInterface $translationService */
        $translationService = self::getService();
        return $translationService->t($bundleName, $key, $variables);
    }

    public static function addBundle(string $bundleName, string $path)
    {
        /** @var TranslationServiceInterface $translationService */
        $translationService = self::getService();
        $translationService->addBundle($bundleName, $path);
    }

}
