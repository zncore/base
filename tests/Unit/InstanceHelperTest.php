<?php

namespace ZnCore\Base\Tests\Unit;

use ZnCore\Base\Helpers\InstanceHelper;
use ZnTool\Test\Base\BaseTest;

class Class1
{

    public function plus(int $a, int $b): int
    {
        return $a + $b;
    }
}

class Class2
{

    private $class1;

    public function __construct(Class1 $class1)
    {
        $this->class1 = $class1;
    }

    public function plus(int $a, int $b): int
    {
        return $this->class1->plus($a, $b);
    }
}

final class InstanceHelperTest extends BaseTest
{

    public function testFromClassName()
    {
        $instance = InstanceHelper::create(Class2::class, [Class1::class => new Class1()]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testFromIndexArgs()
    {
        $definition = [
            'class' => Class2::class,
        ];
        $instance = InstanceHelper::create($definition, [new Class1()]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testFromNamedArgs()
    {
        $definition = [
            'class' => Class2::class,
        ];
        $instance = InstanceHelper::create($definition, ['class1' => new Class1()]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testFromDefinition()
    {
        $definition = [
            'class' => Class2::class,
        ];
        $instance = InstanceHelper::create($definition, [Class1::class => new Class1()]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testFromDefinitionWithConstruct()
    {
        $definition = [
            'class' => Class2::class,
            '__construct' => [
                Class1::class => new Class1()
            ],
        ];
        $instance = InstanceHelper::create($definition);
        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCallMethodFromIndexArgs()
    {
        $definition = [
            'class' => Class2::class,
            '__construct' => [
                Class1::class => new Class1()
            ],
        ];
        $instance = InstanceHelper::create($definition);
        $args = [1, 3];
        $sum = InstanceHelper::callMethod($instance, 'plus', $args);
        $this->assertEquals(4, $sum);
    }

    public function testCallMethodFromNamesArgs()
    {
        $definition = [
            'class' => Class2::class,
            '__construct' => [
                Class1::class => new Class1()
            ],
        ];
        $instance = InstanceHelper::create($definition);
        $args = [
            'a' => 1,
            'b' => 3,
        ];
        $sum = InstanceHelper::callMethod($instance, 'plus', $args);
        $this->assertEquals(4, $sum);
    }
}
