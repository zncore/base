<?php

namespace ZnCore\Base\Helpers;

class HtmlHelper
{

    public static function generateBase64Content(string $content, string $mimeType): string
    {
        $base64Content = base64_encode($content);
        return "data:{$mimeType};base64, {$base64Content}";
    }
}
