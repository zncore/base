<?php

namespace ZnCore\Base\Helpers;

use Symfony\Component\Mime\MimeTypes;
use ZnCore\Base\Enums\Measure\ByteEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use PATHINFO_EXTENSION;

class MimeTypeHelper
{

    public static function getMimeTypeByFileName(string $fileName): ?string {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        return self::getMimeTypeByExt($ext);
    }
    
    public static function getMimeTypeByExt(string $ext): ?string {
        $types = self::getMimeTypesByExt($ext);
        return ArrayHelper::first($types);
    }

    public static function getMimeTypesByExt(string $ext): ?array {
        return MimeTypes::getDefault()->getMimeTypes($ext);
    }

    public static function getExtensionByMime(string $mimeType): ?string {
        $extensions = self::getExtensionsByMime($mimeType);
        return ArrayHelper::first($extensions);
    }

    public static function getExtensionsByMime(string $mimeType): ?array {
        return MimeTypes::getDefault()->getExtensions($mimeType);
    }
}
