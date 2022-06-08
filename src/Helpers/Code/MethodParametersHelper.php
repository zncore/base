<?php

namespace ZnCore\Base\Helpers\Code;

use ReflectionNamedType;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ReflectionClass;
use Exception;
use ReflectionException;

class MethodParametersHelper
{

    public static function prepareParameters(string $className, string $methodName, array $constructionArgs = []): array
    {
        if (!ArrayHelper::isIndexed($constructionArgs)) {
            $reflectionClass = new ReflectionClass($className);
            try {
                $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
                $flatParameters = self::extractParams($constructorParameters, $constructionArgs);
                ksort($flatParameters);
                $constructionArgs = $flatParameters;
            } catch (ReflectionException $e) {
            }
        }
        return $constructionArgs;
    }

    /**
     * @param array | \ReflectionParameter[] $constructorParameters
     * @param array $constructionArgs
     * @return array
     */
    protected static function extractParams(array $constructorParameters, array $constructionArgs = []): array {
        $flatParameters = [];
        foreach ($constructorParameters as $index => $constructorParameter) {
            $parameterType = $constructorParameter->getType();
            if ($parameterType && array_key_exists($parameterType->getName(), $constructionArgs)) {
                $parameterName = $parameterType->getName();
            } else {
                $parameterName = $constructorParameter->getName();
            }
            if (array_key_exists($parameterName, $constructionArgs)) {
                $flatParameters[$index] = $constructionArgs[$parameterName];
                unset($constructionArgs[$parameterName]);
            } else {
                if (!$parameterType->allowsNull()) {
                    try {
                        $flatParameters[$index] = ContainerHelper::getContainer()->get($parameterType->getName());
                    } catch (Exception $e) {
                    }
                }
            }
        }
        foreach ($constructorParameters as $index => $constructorParameter) {
            if (!isset($flatParameters[$index])) {
                foreach ($constructionArgs as $constructionArgName => $constructionArgValue) {
                    if (is_int($constructionArgName)) {
                        $flatParameters[$index] = $constructionArgValue;
                    }
                }
            }
        }
        return $flatParameters;
    }
}
