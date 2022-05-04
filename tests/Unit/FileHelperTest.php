<?php

namespace ZnCore\Base\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ZnCore\Base\Helpers\FileSizeHelper;
use ZnCore\Base\Helpers\FindFileHelper;
use ZnCore\Base\Helpers\MimeTypeHelper;
use ZnCore\Domain\Helpers\EntityHelper;

final class FileHelperTest extends TestCase
{

    public function testScanDirTree()
    {
        $tree = FindFileHelper::scanDirTree(__DIR__ . '/../../src/i18next');

        $array = EntityHelper::collectionToArray($tree);
        $json = json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $this->assertEquals(file_get_contents(__DIR__ . '/../data/FileHelper/testScanDirTree.json'), $json);
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
        $size = FileSizeHelper::sizeFormat(1022475);

        $this->assertEquals('998.51 KB', $size);
    }
}
