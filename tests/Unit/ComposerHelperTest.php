<?php

namespace ZnCore\Base\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ZnCore\Base\Helpers\ComposerHelper;

final class ComposerHelperTest extends TestCase
{

    public function testBasics()
    {
        ComposerHelper::register('App1', __DIR__ . '/../classes');
        $cc = new \App1\Cc;
        $this->assertEquals(\App1\Cc::class, get_class($cc));

        $dir = ComposerHelper::getPsr4Path('App1');
        $this->assertEquals(realpath(__DIR__ . '/../classes'), $dir);
    }

    public function testBasics1()
    {
        ComposerHelper::getComposerVendorClassLoader()->addPsr4('App1\\', __DIR__ . '/../classes');
        $cc = new \App1\Cc;
        $this->assertEquals(\App1\Cc::class, get_class($cc));

        $dir = ComposerHelper::getPsr4Path('App1');
        $this->assertEquals(realpath(__DIR__ . '/../classes'), $dir);
    }

    public function testBasics12()
    {
        $dir = ComposerHelper::getPsr4Path('ZnCore\\Base\\Helpers');
        $this->assertEquals(realpath(__DIR__ . '/../../../../zncore/base/src/Helpers'), $dir);
    }
}