<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Legacy\Yii\Base\Model;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Exceptions\UnprocessableEntityHttpException;
use ZnCore\Domain\Helpers\EntityHelper;

class Helper
{

    public static function idsToArray($param)
    {
        if (empty($param)) {
            return [];
        }
        if (!is_array($param)) {
            $param = explode(',', $param);
        }
        $param = array_map('trim', $param);
        //$param = array_map('intval', $param);
        //$param = array_map(function(){}, $param);
        return $param;
    }

    public static function forgeEntity($value, string $className, bool $isCollection = null, $isSaveKey = false)
    {

        //throw new \ZnCore\Base\Exceptions\DeprecatedException;

        if (empty($value)) {
            return null;
        }
        if ($value instanceof $className) {
            return $value;
        }
        if (!is_array($value)) {
            return null;
        }
        if (ArrayHelper::isIndexed($value) || $isCollection) {
            $result = [];
            foreach ($value as $key => &$item) {
                if ($isSaveKey) {
                    $result[$key] = self::forgeEntity($item, $className);
                } else {
                    $result[] = self::forgeEntity($item, $className);
                }
            }
        } else {
            $result = new $className();
            EntityHelper::setAttributes($result, $value);
            //$result->load($value);
        }
        /*if($isCollection !== null) {
            if() {

            }
        }*/
        return $result;
    }

    public static function post($data = null, Model $model = null)
    {
        if (empty($data) && is_object($model)) {
            $data = \Yii::$app->request->post($model->formName());
        }
        if (empty($data)) {
            $data = \Yii::$app->request->post();
        }
        return $data;
    }

    public static function isEnabledComponent($config)
    {
        if (!is_array($config)) {
            return $config;
        }
        $isEnabled = !isset($config['isEnabled']) || !empty($config['isEnabled']);
        unset($config['isEnabled']);
        if (!$isEnabled) {
            return null;
        }
        return $config;
    }

    /*public static function forgeForm(Model $model, $data = null)
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        $data = self::post($data, $model);
        $model->setAttributes($data, false);
//        if(!$model->validate()) {
//            throw new UnprocessableEntityHttpException($model);
//        }
    }

    public static function createForm($form, $data = null, $scenario = null): Model
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        if (is_string($form) || is_array($form)) {
            $form = ClassHelper::createObject($form);
        }

        if (!empty($data)) {
            ClassHelper::configure($form, $data);
        }
        if (!empty($scenario)) {
            $form->scenario = $scenario;
        }
        return $form;
    }

    public static function validateForm($form, $data = null, $scenario = null)
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        $form = self::createForm($form, $data, $scenario);
        if (!$form->validate()) {
            throw new UnprocessableEntityHttpException($form);
        }
        return $form->getAttributes();
    }


    public static function toArray($value, $recursive = true)
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        if (is_object($value) && method_exists($value, 'toArray')) {
            return $value->toArray([], [], $recursive);
        }
        if (!ArrayHelper::isIndexed($value)) {
            return $value;
        }
        foreach ($value as &$item) {
            $item = self::toArray($item, $recursive);
        }
        return $value;
    }


    public static function microtimeId($length = 14)
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        $timeArray = explode('.', microtime(true));
        $time = implode('', $timeArray);
        $time = strval($time);
        $time = StringHelper::fill($time, $length, '0');
        if ($length > 14) {
            $diff = $length - 14;
            $min = str_repeat('0', $diff);
            $max = str_repeat('9', $diff);
            $rand = mt_rand($min, $max);
            $time .= $rand;
        }
        return $time;
    }

    public static function includeConfig(string $file, array $mergeConfig = []): array
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        $parentConfig = include($file);
        return ArrayHelper::merge($parentConfig, $mergeConfig);
    }

    public static function list2tree($secureAttributes)
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        $tree = [];
        foreach ($secureAttributes as $attribute) {
            ArrayHelper::setValue($tree, $attribute, true);
        }
        return $tree;
    }

    public static function parseParams($path, $delimiter, $subDelimiter)
    {

        throw new \ZnCore\Base\Exceptions\DeprecatedException;

        $isHasParams = strpos($path, $delimiter);
        if (!$isHasParams) {
            return null;
        }
        $params = [];
        $segments = explode($delimiter, $path);
        foreach ($segments as $segment) {
            $s = explode($subDelimiter, $segment);
            if (count($s) > 1) {
                $params[$s[0]] = $s[1];
            } else {
                $params[] = $s[0];
            }
        }
        return $params;
    }

    public static function getNotEmptyValue()
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!empty($arg)) {
                return $arg;
            }
        }
        return null;
    }*/

    /*public static function assignAttributesForList($configList, $attributes = null)
    {
        $configList = ClassHelper::normalizeComponentListConfig($configList);
        foreach ($configList as &$item) {
            foreach ($attributes as $attributeName => $attributeValue) {
                $item[$attributeName] = $attributeValue;
            }
        }
        return $configList;
    }

    static function getBundlePath($path)
    {
        if (empty($path)) {
            return false;
        }
        $alias = FileHelper::normalizeAlias($path);
        $dir = FileHelper::getAlias($alias);
        if (!is_dir($dir)) {
            return false;
        }
        return $alias;
    }

    static function timeForApi($value, $default = null, $mask = 'Y-m-d\TH:i:s\Z')
    {
        if (APP != API) {
            return $value;
        }
        if (empty($value)) {
            return $default;
        }
        if (is_numeric($value)) {
            $value = date('Y-m-d H:i:s', $value);
        }
        $datetime = new DateTime($value);
        $value = $datetime->format($mask);
        return $value;
    }*/

}