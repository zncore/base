<?php

namespace ZnCore\Base\Helpers;

use Exception;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Exceptions\NotInstanceOfException;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Domain\Helpers\EntityHelper;

class ClassHelper
{

    /*public static function normalizeClassName($className)
    {
        $className = trim($className, '@/\\');
        $className = str_replace('/', '\\', $className);
        return $className;
    }*/

    public static function instanceOf($instance, $interface, bool $allowString = false): bool
    {
        try {
            self::checkInstanceOf($instance, $interface, $allowString);
            return true;
        } catch (NotInstanceOfException $e) {
            return false;
        }
    }

    public static function checkInstanceOf($instance, $interface, bool $allowString = false): void
    {
        if (empty($instance)) {
            throw new InvalidArgumentException("Argument \"instance\" is empty");
        }
        if (empty($interface)) {
            throw new InvalidArgumentException("Argument \"interfaceClass\" is empty");
        }
        if (!is_object($instance) && !is_string($instance)) {
            throw new InvalidArgumentException("Instance not is object and not is string");
        }
        if (!interface_exists($interface) && !class_exists($interface)) {
            throw new InvalidArgumentException("Interface \"$interface\" not exists");
        }
        if(is_string($instance) && !$allowString) {
            throw new InvalidArgumentException("Instance as string not allowed");
        }

        if(is_string($instance)) {
            $reflection = new \ReflectionClass($instance);
            $interfaces = $reflection->getInterfaces();
            if(!array_key_exists($interface, $interfaces)) {
                self::throwNotInstanceOfException($instance, $interface);
//                throw new NotInstanceOfException("Class \"$instance\" not instanceof \"$interface\"");
            }
        } elseif (!$instance instanceof $interface) {
            self::throwNotInstanceOfException($instance, $interface);
//            $instanceClassName = get_class($instance);
//            throw new NotInstanceOfException("Class \"$instanceClassName\" not instanceof \"$interface\"");
        }
    }

    private static function throwNotInstanceOfException($instanceClassName, string $interface) {
        $instanceClassName = is_object($instanceClassName) ? get_class($instanceClassName) : $instanceClassName;
        throw new NotInstanceOfException("Class \"$instanceClassName\" not instanceof \"$interface\"");
    }

    /*
     * @param $instance
     * @param $interface
     * @param bool $allowString
     * @throws NotInstanceOfException
     * @deprecated
     * @todo переделать на тип bool
     */
    /*public static function isInstanceOf($instance, $interface, bool $allowString = false): void
    {
        DeprecateHelper::softThrow();
        self::checkInstanceOf($instance, $interface, $allowString);
    }*/

    public static function getInstanceOfClassName($class, $classname)
    {
        $class = self::getClassName($class, $classname);
        if (empty($class)) {
            return null;
        }
        if (class_exists($class)) {
            return new $class();
        }
        return null;
    }

    public static function getNamespaceOfClassName($class)
    {
        $lastSlash = strrpos($class, '\\');
        return substr($class, 0, $lastSlash);
    }

    public static function getClassOfClassName($class)
    {
        $lastPos = strrpos($class, '\\');
        $name = substr($class, $lastPos + 1);
        return $name;
    }

    public static function extractNameFromClass($class, $type)
    {
        $lastPos = strrpos($class, '\\');
        $name = substr($class, $lastPos + 1, 0 - strlen($type));
        return $name;
    }

    /**
     * Создать объект
     * @param string|object|array $definition Определение
     * @param array $params Параметры конструктора
     * @return mixed
     * @throws InvalidConfigException
     * @throws NotInstanceOfException
     */
    public static function createInstance($definition, array $params = [], ContainerInterface $container = null)
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        if(is_object($definition)) {
            return $definition;
        }
        $definition = self::normalizeComponentConfig($definition);
        if($container == null) {
            $container = ContainerHelper::getContainer();
        }
        $instance = $container->make($definition['class'], $params);
        if($definition['class']) {
            unset($definition['class']);
        }
        EntityHelper::setAttributes($instance, $definition);
        return $instance;
    }

    /**
     * Создать объект
     * @param string|object|array $definition Определение
     * @param array $params Атрибуты объекта
     * @param null $interface
     * @return mixed
     * @throws InvalidConfigException
     * @throws NotInstanceOfException
     */
    public static function createObject($definition, array $params = [], $interface = null)
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        if(is_object($definition)) {
            return $definition;
        }
        $definition = self::normalizeComponentConfig($definition);
        $container = ContainerHelper::getContainer();
        $object = $container->make($definition['class']);
        //$object = new $definition['class'];
        if($definition['class']) {
            unset($definition['class']);
        }
        EntityHelper::setAttributes($object, $definition);
        EntityHelper::setAttributes($object, $params);
//        self::configure($object, $params);
//        self::configure($object, $definition);
        if (!empty($interface)) {
            self::checkInstanceOf($object, $interface);
        }
        return $object;
    }

    public static function configure(object $object, array $properties)
    {
        if (empty($properties)) {
            return $object;
        }
        foreach ($properties as $name => $value) {
            if ($name != 'class') {
                if(EntityHelper::isWritableAttribute($object, $name)) {
                    EntityHelper::setAttribute($object, $name, $value);
                }
//                $object->{$name} = $value;
            }
        }
        return $object;
    }

    static function getClassName(string $className, string $namespace)
    {
        if (empty($namespace)) {
            return $className;
        }
        if (!ClassHelper::isClass($className)) {
            $className = $namespace . '\\' . ucfirst($className);
        }
        return $className;
    }

    public static function getNamespace(string $name)
    {
        $name = trim($name, '\\');
        $arr = explode('\\', $name);
        array_pop($arr);
        $name = implode('\\', $arr);
        return $name;
    }

    static function normalizeComponentListConfig($config)
    {
        if (empty($config)) {
            return [];
        }
        $components = [];
        foreach ($config as $id => &$definition) {
            $definition = self::normalizeComponentConfig($definition);
            if (self::isComponent($id, $definition)) {
                $components[$id] = $definition;
            }
        }
        return $components;
    }

    static function isComponent($id, $definition)
    {
        if (empty($definition)) {
            return false;
        }
        return PhpHelper::isValidName($id) && array_key_exists('class', $definition);
    }

    static function normalizeComponentConfig($config, $class = null)
    {
        if (empty($config) && empty($class)) {
            return $config;
        }
        if (!empty($class)) {
            $config['class'] = $class;
        }
        if (is_array($config)) {
            return $config;
        }
        if (self::isClass($config)) {
            $config = ['class' => $config];
        }
        return $config;
    }

    static function isClass($name)
    {
        return is_string($name) && (strpos($name, '\\') !== false || class_exists($name));
    }
}