<?php

namespace ZnCore\Base\Libs\Code;

use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;

class MethodParametersResolver
{

    use ContainerAwareTrait;

    private $instanceResolver;

    public function __construct(ContainerInterface $container = null, InstanceResolver $instanceResolver = null)
    {
        $this->setContainer($container);
        $this->instanceResolver = $instanceResolver;
    }

    public function getInstanceResolver(): InstanceResolver
    {
        return $this->instanceResolver ?: new InstanceResolver($this->container);
    }

    public function resolve(string $className, string $methodName, array $constructionArgs = []): array
    {


        if (!ArrayHelper::isIndexed($constructionArgs) || empty($constructionArgs)) {
//            $reflectionClass = new ReflectionClass($className);
            try {
//                $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
                $constructorParameters = $this->extractMethodParameters($className, $methodName);

//                if(empty($constructionArgs)) {
//                    $constructorParameters = $this-

//                    dd($constructionArgs);
                    $constructionArgs = $this->extractParams($constructorParameters, $constructionArgs);
//                    dd($constructionArgs);
                    /*foreach ($constructorParameters as $constructorParameter) {

                    }*/

                    //dd($className, $methodName, $constructionArgs, $constructorParameters);
//                }


//                $constructionArgs = $this->extractParams($constructorParameters, $constructionArgs);
            } catch (ReflectionException $e) {
            }
        }
        return $constructionArgs;
    }

    protected function extractMethodParameters(string $className, string $methodName): array {
        $reflectionClass = new ReflectionClass($className);
        $constructorParameters = $reflectionClass->getMethod($methodName)->getParameters();
        return $constructorParameters;
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
            $className = $parameterType->getName();
            if (class_exists($className)) {
                if ($this->ensureContainer()) {
                    return $this->getContainer()->get($className);
                } else {
                    $instanceResolver = $this->getInstanceResolver();
                    return $instanceResolver->create($className);
                }
            } else {
                return $constructorParameter->getDefaultValue();
//                dd($constructorParameter->getDefaultValue());
            }
        }
    }

    /**
     * @param ReflectionParameter[] $constructorParameters
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
//        dd($flatParameters);
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
