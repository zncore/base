<?php

namespace ZnCore\Base\Tests\Unit;

use ZnCore\Base\Helpers\InstanceHelper;
use ZnCore\Base\Libs\Code\InstanceResolver;
use ZnTool\Test\Base\BaseTest;
use App1\Class0;
use App1\Class1;
use App1\Class2;

require_once __DIR__ . '/../classes/Class0.php';
require_once __DIR__ . '/../classes/Class1.php';
require_once __DIR__ . '/../classes/Class2.php';

final class InstanceResolverTest extends BaseTest
{

    public function testCreateAll()
    {
        $instanceResolver = new InstanceResolver();
        $instance = $instanceResolver->create(Class2::class);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCreateInstanceFromClassName()
    {
        $instanceResolver = new InstanceResolver();
        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create(Class2::class, [Class1::class => $class1]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCreateInstanceFromIndexArgs()
    {
        $definition = [
            'class' => Class2::class,
        ];
        $instanceResolver = new InstanceResolver();

        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create($definition, [$class1]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCreateInstanceFromNamedArgs()
    {
        $definition = [
            'class' => Class2::class,
        ];
        $instanceResolver = new InstanceResolver();

        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create($definition, ['class1' => $class1]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCreateInstanceFromDefinition()
    {
        $definition = [
            'class' => Class2::class,
        ];
        $instanceResolver = new InstanceResolver();
        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create($definition, [Class1::class => $class1]);

        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCreateInstanceFromDefinitionWithConstruct()
    {

        $instanceResolver = new InstanceResolver();
        $class1 = $instanceResolver->create(Class1::class);

        $definition = [
            'class' => Class2::class,
            '__construct' => [
                Class1::class => $class1
            ],
        ];
        $instance = $instanceResolver->create($definition);
        $this->assertInstanceOf(Class2::class, $instance);
        $this->assertEquals(4, $instance->plus(1,3));
    }

    public function testCallMethodFromIndexArgs()
    {
        $instanceResolver = new InstanceResolver();
        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create(Class2::class, [$class1]);
        $args = [
            'a' => 7,
            Class1::class => $class1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'method1', $args);
        $this->assertEquals(10, $sum);

        $args = [1, 3];
        $sum = $instanceResolver->callMethod($instance, 'plus', $args);
        $this->assertEquals(4, $sum);
    }

    public function testCallMethodFromTypeArgs()
    {
        $instanceResolver = new InstanceResolver();

        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create(Class2::class, [$class1]);
        $args = [
            'a' => 7,
            Class1::class => $class1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'method1', $args);
        $this->assertEquals(10, $sum);
    }

    public function testCallMethodFromNameArgs()
    {
        $instanceResolver = new InstanceResolver();

        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create(Class2::class, [$class1]);
        $args = [
            'a' => 7,
            'class1' => $class1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'method1', $args);
        $this->assertEquals(10, $sum);

        $args = [
            'a' => 1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'plus', $args);
        $this->assertEquals(4, $sum);
    }

    public function testCallMethodFromBothArgs()
    {
        $instanceResolver = new InstanceResolver();

        $class1 = $instanceResolver->create(Class1::class);
        $instance = $instanceResolver->create(Class2::class, [$class1]);
        $args = [
            'a' => 7,
            $class1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'method1', $args);
        $this->assertEquals(10, $sum);

        $args = [
            'a' => 7,
            Class1::class => $class1,
            3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'method1', $args);
        $this->assertEquals(10, $sum);

        $args = [
            7,
            Class1::class => $class1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'method1', $args);
        $this->assertEquals(10, $sum);

        $args = [
            1,
            'b' => 3,
        ];
        $sum = $instanceResolver->callMethod($instance, 'plus', $args);
        $this->assertEquals(4, $sum);
    }
}
