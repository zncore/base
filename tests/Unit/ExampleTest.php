<?php

namespace ZnCore\Base\Tests\Unit;

use ZnTool\Test\Base\BaseTest;

class Mapper
{

    private $map = [];

    public function map()
    {
        return $this->map;
    }

    public function setMap(array $map)
    {
        $this->map = $map;
    }

    public function encode(array $data)
    {
        $newData = [];
        foreach ($this->map as $name => $nameEncoded) {
            if($nameEncoded === null) {
                $nameEncoded = $name;
            }
            $newData[$nameEncoded] = $data[$name];
        }
        return $newData;
    }

    public function decode(array $data)
    {

    }
}

final class ExampleTest extends BaseTest
{

    public function testExample()
    {
        $this->assertTrue(true);
    }

    /*public function testExample2()
    {


        $mapper = new Mapper;
        $mapper->setMap([
            'name' => 'title',
            'code' => 'id',
            'description' => null,
        ]);
        $encoded = $mapper->encode([
            'name' => 'name111',
            'code' => 111,
        ]);

        $this->assertEquals($encoded, [
            'title' => 'name111',
            'id' => 111,
            //'description' => null,
        ]);
    }*/

}