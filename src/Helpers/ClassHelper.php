<?php

namespace ZnCore\Base\Helpers;

use Exception;
use ZnCore\Base\Exceptions\InvalidArgumentException;
use ZnCore\Base\Exceptions\InvalidConfigException;
use ZnCore\Base\Exceptions\NotInstanceOfException;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Domain\Helpers\EntityHelper;

class ClassHelper
{

    public static function normalizeClassName($className)
    {
        $className = trim($className, '@/\\');
        $className = str_replace('/', '\\', $className);
        return $className;
    }

    public static function isInstanceOf($instance, $interface, bool $allowString = false): void
    {
        if (empty($instance)) {
            throw new InvalidArgumentException("Argument \"instance\" is empty");
        }
        if (empty($interface)) {
            throw new InvalidArgumentException("Argument \"interfaceClass\" is empty");
        }
        if (!interface_exists($interface) && !class_exists($interface)) {
            throw new InvalidArgumentException("Interface \"$interface\" not exists");
        }
        if(is_string($instance) && $allowString) {
            $reflection = new \ReflectionClass($instance);
            $interfaces = $reflection->getInterfaces();
            if(!array_key_exists($interface, $interfaces)) {
                throw new NotInstanceOfException("Class \"$instance\" not instanceof \"$interface\"");
            }
            return;
        }
        if (!is_object($instance)) {
            throw new InvalidArgumentException("Not is object");
        }

        if (!$instance instanceof $interface) {
            $instanceClassName = get_class($instance);
            throw new NotInstanceOfException("Class \"$instanceClassName\" not instanceof \"$interface\"");
        }
    }

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
        $object = $container->get($definition['class']);
        //$object = new $definition['class'];
        if($definition['class']) {
            unset($definition['class']);
        }
        EntityHelper::setAttributes($object, $params);
        EntityHelper::setAttributes($object, $definition);
//        self::configure($object, $params);
//        self::configure($object, $definition);
        if (!empty($interface)) {
            self::isInstanceOf($object, $interface);
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
                EntityHelper::setAttribute($object, $name, $value);
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