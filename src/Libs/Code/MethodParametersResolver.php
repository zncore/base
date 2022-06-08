<?php

namespace ZnCore\Base\Libs\Code;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;

class MethodParametersResolver
{

    use ContainerAwareTrait;

    public function resolve(string $className, string $methodName, array $constructionArgs = []): array
    {
        if (!ArrayHelper::isIndexed($constructionArgs)) {
            $reflectionClass = new ReflectionClass($className);
            try {
                $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
                $constructionArgs = $this->extractParams($constructorParameters, $constructionArgs);
            } catch (ReflectionException $e) {
            }
        }
        return $constructionArgs;
    }

    protected function extractParameterName(ReflectionParameter $constructorParameter, array $constructionArgs = []): string
    {
        $parameterType = $constructorParameter->getType();
        if ($parameterType && array_key_exists($parameterType->getName(), $constructionArgs)) {
            $parameterName = $parameterType->getName();
        } else {
            $parameterName = $constructorParameter->getName();
        }
        return $parameterName;
    }

    protected function extractParameterValue(ReflectionParameter $constructorParameter, array $constructionArgs = [])
    {
        $parameterName = $this->extractParameterName($constructorParameter, $constructionArgs);
        if (array_key_exists($parameterName, $constructionArgs)) {
            return $constructionArgs[$parameterName];
            //unset($constructionArgs[$parameterName]);
        } else {
            $parameterType = $constructorParameter->getType();
            if (!$parameterType->allowsNull()) {
                return $this->getContainer()->get($parameterType->getName());
            }
        }
    }

    /**
     * @param array | ReflectionParameter[] $constructorParameters
     * @param array $constructionArgs
     * @return array
     */
    protected function extractParams(array $constructorParameters, array $constructionArgs = []): array
    {
        $flatParameters = [];
        foreach ($constructorParameters as $index => $constructorParameter) {
            try {
                $parameterValue = $this->extractParameterValue($constructorParameter, $constructionArgs);
                $flatParameters[$index] = $parameterValue;
            } catch (Exception $e) {
            }
        }

        $flatParameters = $this->fillEmptyParameters($constructorParameters, $flatParameters, $constructionArgs);

        ksort($flatParameters);
        return $flatParameters;
    }

    protected function fillEmptyParameters(array $constructorParameters, array $flatParameters, array $constructionArgs = []): array
    {
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
