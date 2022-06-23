<?php

namespace ZnCore\Base\Tests\Unit;

use ZnCore\Domain\Entity\Helpers\CollectionHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FileSizeHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\FindFileHelper;
use ZnCore\Base\Libs\FileSystem\Helpers\MimeTypeHelper;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnTool\Test\Asserts\DataAssert;
use ZnTool\Test\Asserts\DataTestCase;

final class FileHelperTest extends DataTestCase
{

    public function testScanDirTree()
    {
        $tree = FindFileHelper::scanDirTree(__DIR__ . '/../../src/CommonTranslate/i18next');
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
        $size = FileSizeHelper::sizeFormat(123);
        $this->assertEquals('123 B', $size);

        $size = FileSizeHelper::sizeFormat(1022475);
        $this->assertEquals('998.51 KB', $size);

        $size = FileSizeHelper::sizeFormat(56461789651);
        $this->assertEquals('52.58 GB', $size);

        $size = FileSizeHelper::sizeFormat(5646178965111111);
        $this->assertEquals('5.01 PB', $size);

        $size = FileSizeHelper::sizeFormat(5999999999999999999);
        $this->assertEquals('5.2 EB', $size);
    }
}
