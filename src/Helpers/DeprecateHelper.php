<?php

namespace ZnCore\Base\Helpers;

use Composer\Autoload\ClassLoader;
use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use ZnCore\Base\Exceptions\DeprecatedException;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;

class DeprecateHelper
{

    private static $isStrictMode = false;

    public static function softThrow(string $message = '')
    {
//        $messageText = 'Deprecated: ' . $message;
        if (self::isStrictMode()) {
            self::hardThrow($message);
            //throw new DeprecatedException($messageText);
        } else {
            //self::log($messageText);
        }
    }

    public static function hardThrow(string $message = '')
    {
        self::log($message, debug_backtrace(), \Monolog\Logger::CRITICAL);
        throw new DeprecatedException('Deprecated: ' . $message);
    }

    public static function isStrictMode(): bool
    {
        return self::getStrictMode() == true;
    }

    public static function setStrictMode()
    {
        self::$isStrictMode = true;
    }

    public static function getStrictMode()
    {
        return $_ENV['DEPRECATE_STRICT_MODE'] ?? self::$isStrictMode;
    }

    private static function log(string $message = '', $trace = [], $level = \Monolog\Logger::NOTICE)
    {
        $container = ContainerHelper::getContainer();
        if (!$container instanceof ContainerInterface) {
            return;
        }
        if (!$container->has(LoggerInterface::class)) {
            return;
        }
        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);
        $noticeMessage = 'Deprecated';
        if ($message) {
            $noticeMessage .= ': ' . $message;
        }

        $logger->log($level, $noticeMessage, [
            'message' => $message,
            'trace' => $trace,
        ]);
        /*$logger->notice($noticeMessage, [
            'message' => $message,
            'trace' => $trace,
        ]);*/
    }
}