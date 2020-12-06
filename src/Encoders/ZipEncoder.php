<?php

namespace ZnCore\Base\Encoders;

use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Interfaces\EncoderInterface;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use Exception;
use ZipArchive;

class ZipEncoder implements EncoderInterface
{

    private $oneFileName;

    public function __construct(string $oneFileName = 'one')
    {
        $this->oneFileName = $oneFileName;
    }

    public function encode($data)
    {
        $tmpDir = self::getTmpDirectory();
        $oneFile = $tmpDir . '/' . $this->oneFileName;
        $zipFile = $tmpDir . '/arch.zip';

        $zip = new ZipArchive();
        $res = $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($res === TRUE) {
//            dd($oneFile);
            file_put_contents($oneFile, $data);
            $zip->addFile($oneFile, $this->oneFileName);
//            $xmlContent = $zip->addFromString('one', $data);
            $zip->close();
        } else {
            throw new Exception('Zip not opened!');
        }
        $binaryContent = file_get_contents($zipFile);
        FileHelper::removeDirectory($tmpDir);
        return $binaryContent;
    }

    public function decode($encodedData)
    {
        $tmpDir = self::getTmpDirectory();
        $oneFile = $tmpDir . '/' . $this->oneFileName;
        $zipFile = $tmpDir . '/arch.zip';

        file_put_contents($zipFile, $encodedData);
        $zip = new ZipArchive();
        $res = $zip->open($zipFile);
        if ($res === TRUE) {
            $xmlContent = $zip->getFromName($this->oneFileName);
            $zip->close();
        } else {
            throw new Exception('Zip not opened!');
        }
        FileHelper::removeDirectory($tmpDir);
        return $xmlContent;
    }

    private static function getTmpDirectory(): string
    {
        $tmpDir = sys_get_temp_dir() . '/qrZip/' . StringHelper::genUuid();
        FileHelper::createDirectory($tmpDir);
        return $tmpDir;
    }

    private function open(): ZipArchive
    {
        $zipFile = tempnam(sys_get_temp_dir(), 'qrZip');
        $zip = new ZipArchive();
        $res = $zip->open($zipFile);
        if ($res !== TRUE) {
            throw new Exception('Zip not opened!');
        }
        return $zip;
    }

    private function close(ZipArchive $zip)
    {
        $zip->close();
        unlink($zipFile);
    }
}