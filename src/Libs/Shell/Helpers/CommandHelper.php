<?php

namespace ZnCore\Base\Libs\Shell\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Shell\CommandForm;

class CommandHelper
{

//    private $lang = 'en_GB';
//    private $commandItems = [];
//    private $path = '.';
    private static $optionGlue = '=';

    protected static function escapeshellarg($arg): string
    {
        if (is_bool($arg)) {
            $arg = intval($arg);
        }
        if (is_int($arg)) {
            return strval($arg);
        }
        return escapeshellarg($arg);

        /*if (is_string($arg)) {
            $arg = escapeshellarg($arg);
            //} elseif (is_array($arg)) {

        } else {
            throw new \Exception('Bad command option type!');
        }
        return $arg;*/
    }

    public static function cleanEmptyArgs(array $args)
    {
        foreach ($args as $key => $value) {
            if (empty($value)) {
                if (is_string($key) && !empty($key)) {
                    $args[$key] = false;
                } else {
                    unset($args[$key]);
                }
            }
        }
        return $args;
    }

    public static function processCommandArg($key, $value)
    {
        $cmd = '';
        if (is_string($key)) {
            $cmd = $key . self::$optionGlue;
        }
        return $cmd . self::escapeshellarg($value);
    }

    public static function processCommandArgs(array $args)
    {
        $args = self::cleanEmptyArgs($args);
        $cmdArr = [];
        foreach ($args as $key => $value) {
            $cmdArr[] = self::processCommandArg($key, $value);
        }

//        foreach ($args as $arg) {
//            if (is_array($arg)) {
//            } elseif (is_scalar($arg) && !is_bool($arg)) {
//                $cmd[] = /*self::escapeshellarg*/($arg);
//            }
//        }
        return $cmdArr;
    }

    public static function generateCommand(array $args): string
    {
        $args = self::processCommandArgs($args);
        return implode(' ', $args);
    }

    protected static function generateLang(CommandForm $commandForm): string
    {
        if ($commandForm->getLang()) {
            return 'LANG=' . $commandForm->getLang();
        }
        return '';
    }

    protected static function generateLang2(?string $lang = null): string
    {
        if ($lang) {
            return 'LANG=' . $lang;
        }
        return '';
    }

    public static function argsToString(array $args, string $langCode = null): string
    {
        $commandName = array_shift($args);
        $langOption = self::generateLang2($langCode);
        $arguments = self::generateCommand($args);
        $command = "{$langOption} {$commandName} {$arguments}";
        return trim($command);
    }

    public static function getCommandString(CommandForm $commandForm): string
    {
        $args = $commandForm->getArguments();
        if($commandForm->getCommand()) {
            $args = ArrayHelper::merge([$commandForm->getCommand()], $args);
        }
        return self::argsToString($args, $commandForm->getLang());





        if ($commandForm->getCommand()) {
            $commandName = $commandForm->getCommand();
        } else {
            $commandName = array_shift($args);
        }
        $lang = self::generateLang($commandForm);


        $arguments = self::generateCommand($args);
        $command = "{$lang} {$commandName} {$arguments}";

        return trim($command);
    }

    public static function setCommandString(string $cmd): void
    {

    }
}
