<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

class XmlEncoderHelper
{

    public static function createMedia(string $mimeType, $content, string $caption = null)
    {
        if (empty($caption)) {
            $ext = MimeTypeHelper::getExtensionByMime($mimeType);
            $caption = 'document.' . $ext;
        }

        $mediaObject = $content;

        /*if (Helper::isBinary($content)) {
            $mediaObject = [
                "@encoding" => "base64",
                "#" => base64_encode($content),
            ];
        } else {
            $mediaObject = $content;
        }*/

        return [
            'media' => [
                "@media-type" => 'text',
                "#" => [
                    'media-reference' => [
                        "@mime-type" => $mimeType,
                    ],
                    'media-object' => $mediaObject,
                    'media.caption' => $caption,
                ],
            ],
        ];
    }
}