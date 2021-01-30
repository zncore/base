<?php

namespace ZnCore\Base\Libs\I18Next\Facades;

use Psr\Container\ContainerInterface;
use Yii;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;

class I18Next
{

//    private static $container;
    private static $service;

    /*public static function setContainer(ContainerInterface $container) {
        $container = ContainerHelper::getContainer();
//        self::$container = $container;
        self::$service = $container->get(TranslationServiceInterface::class);
    }*/

    public static function getService(): TranslationServiceInterface {
        return self::$service;
    }

    public static function setService(TranslationServiceInterface $translationService) {
        self::$service = $translationService;
    }

    public static function t(string $bundleName, string $key, array $variables = [])
    {
        $translationService = self::getService();
        return $translationService->t($bundleName, $key, $variables);
    }

    public static function translateFromArray(array $bundleName, string $key = null, array $variables = [])
    {
        $translationService = self::getService();
        return call_user_func_array([$translationService, 't'], $bundleName);
    }

    public static function addBundle(string $bundleName, string $path)
    {
        /** @var TranslationServiceInterface $translationService */
        $translationService = self::getService();
        $translationService->addBundle($bundleName, $path);
    }
}
