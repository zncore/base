<?php

namespace ZnCore\Base\Tests\Unit;

use ZnLib\Components\Byte\Helpers\ByteSizeFormatHelper;
use ZnCore\FileSystem\Helpers\FindFileHelper;
use ZnCore\FileSystem\Helpers\MimeTypeHelper;
use ZnCore\Entity\Helpers\CollectionHelper;
use ZnTool\Test\Asserts\DataAssert;
use ZnTool\Test\Asserts\DataTestCase;

final class FileHelperTest extends DataTestCase
{

    public function testScanDirTree()
    {
        $tree = FindFileHelper::scanDirTree(__DIR__ . '/../data/scanDirTree/i18next');
        $array = CollectionHelper::toArray($tree);
        $expected = $this->loadFromJsonFile(__DIR__ . '/../data/FileHelper/testScanDirTree.json');
        $this->assertArraySubset($expected, $array);
    }

    public function testGetMimeTypes()
    {
        $types = MimeTypeHelper::getMimeTypesByExt('json');

        $this->assertEquals([
            "application/json",
            "application/schema+json",
        ], $types);
    }

    public function testGetMimeType()
    {
        $types = MimeTypeHelper::getMimeTypeByExt('json');

        $this->assertEquals("application/json", $types);
    }

    public function testGetExtensions()
    {
        $extensions = MimeTypeHelper::getExtensionsByMime('application/json');

        $this->assertEquals([
            'json',
            'map',
        ], $extensions);
    }

    public function testGetExtension()
    {
        $extensions = MimeTypeHelper::getExtensionByMime('application/json');

        $this->assertEquals('json', $extensions);
    }

    public function testSize()
    {
        $size = ByteSizeFormatHelper::sizeFormat(123);
        $this->assertEquals('123 B', $size);

        $size = ByteSizeFormatHelper::sizeFormat(1022475);
        $this->assertEquals('998.51 KB', $size);

        $size = ByteSizeFormatHelper::sizeFormat(56461789651);
        $this->assertEquals('52.58 GB', $size);

        $size = ByteSizeFormatHelper::sizeFormat(5646178965111111);
        $this->assertEquals('5.01 PB', $size);

        $size = ByteSizeFormatHelper::sizeFormat(5999999999999999999);
        $this->assertEquals('5.2 EB', $size);
    }
}
