<?php

namespace ZnCore\Base\Libs\Text\Helpers;

use Symfony\Component\Uid\Uuid;
use ZnCore\Base\Libs\Develop\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\Text\Libs\RandomString;

DeprecateHelper::hardThrow();

class StringHelper
{
/*
    const PATTERN_SPACES = '#\s+#m';
    const WITHOUT_CHAR = '#\s+#m';
    const NUM_CHAR = '#\D+#m';*/

    /*public static function implode(array $list, string $begin, string $end, string $spliter = ' '): string
    {
        return $begin . implode("{$end}{$spliter}{$begin}", $list) . $end;
    }

    public static function utf8ize($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = self::utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
        return $mixed;
    }*/

    /*
     * Векторизует текст для получения хэша или подписи.
     *
     * Заменяет двойные пробелы и переносы на точку.
     * В результате получается сплошная строка.
     *
     * @param $data
     * @return string
     */
    /*public static function vectorizeText($data)
    {
        $data = StringHelper::textToLine($data);
        $data = StringHelper::removeDoubleSpace($data);
        $data = str_replace(' ', '.', $data);
        return $data;
    }*/

    /*public static function formatByMask($login, $mask)
    {
        $maskArray = str_split($mask, 1);
        $pos = 0;
        $result = '';
        foreach ($maskArray as $char) {
            if (is_numeric($char)) {
                if ($char == '9') {
                    $result .= $login[$pos];
                    $pos++;
                } else {
                    $result .= $char;
                }
            } else {
                $result .= $char;
            }
        }
        return $result;
    }*/

    /*public static function stripContent($data, $beginText, $endText)
    {
        $pattern = preg_quote($beginText) . '[\s\S]+' . preg_quote($endText);
        $data = preg_replace('#' . $pattern . '#i', '', $data);
        return $data;
    }*/

    /*
     * @return array
     * @deprecated
     * @see Uuid::v4()
     */
    /*public static function genUuid()
    {
        return Uuid::v4()->toRfc4122();
    }*/

    /*public static function search($haystack, $needle, $offset = 0)
    {
        $needle = self::prepareTextForSearch($needle);
        $haystack = self::prepareTextForSearch($haystack);
        if (empty($needle) || empty($haystack)) {
            return false;
        }
        $isExists = mb_strpos($haystack, $needle, $offset) !== false;
        return $isExists;
    }

    private static function prepareTextForSearch($text)
    {
        $text = self::extractWords($text);
        $text = mb_strtolower($text);
        $text = self::removeAllSpace($text);
        return $text;
    }*/

    /*public static function getWordRate($content)
    {
        $content = mb_strtolower($content);
        $wordArray = self::getWordArray($content);
        $result = [];
        foreach ($wordArray as $word) {
            if (!is_numeric($word) && mb_strlen($word) > 1) {
                $result[$word] = isset($result[$word]) ? $result[$word] + 1 : 1;
            }
        }
        arsort($result);
        return $result;
    }

    public static function textToLine($text)
    {
        $text = preg_replace(self::PATTERN_SPACES, ' ', $text);
        return $text;
    }*/
}
