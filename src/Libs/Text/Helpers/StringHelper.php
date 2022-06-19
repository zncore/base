<?php

namespace ZnCore\Base\Libs\Text\Helpers;

use Symfony\Component\Uid\Uuid;
use ZnCore\Base\Libs\Text\Libs\RandomString;

class StringHelper
{

    const PATTERN_SPACES = '#\s+#m';
    const WITHOUT_CHAR = '#\s+#m';
    const NUM_CHAR = '#\D+#m';

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

    public static function fill($value, $length, $char, $place = 'after')
    {
        $value = strval($value);
        $len = mb_strlen($value);
        if ($length > $len) {
            $mock = str_repeat($char, $length - $len);
            if ($place == 'after') {
                $value = $value . $mock;
            } else {
                $value = $mock . $value;
            }
        }
        return $value;
    }

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

    public static function setTab($content, $tabCount)
    {
        $content = str_replace(str_repeat(' ', $tabCount), "\t", $content);
        return $content;
    }

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

    public static function getWordArray($content)
    {
        $content = self::extractWords($content);
        return self::textToArray($content);
    }

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

    public static function normalizeNewLines($text)
    {
        $text = str_replace(PHP_EOL, "\n", $text);
        return $text;
    }

    public static function textToLines($text)
    {
        $text = self::normalizeNewLines($text);
        $text = explode("\n", $text);
        return $text;
    }

    public static function removeDoubleSpace($text)
    {
        return preg_replace(self::PATTERN_SPACES, ' ', $text);
//        return self::removeDoubleChar($text, self::PATTERN_SPACES);
    }

    public static function removeDoubleChar($text, string $char)
    {
        $text = preg_replace('#'.preg_quote($char).'+#m', $char, $text);
        return $text;
    }

    public static function removeAllSpace($text)
    {
        $text = preg_replace(self::PATTERN_SPACES, '', $text);
        return $text;
    }

    public static function filterNumOnly($text, $charSet = self::NUM_CHAR)
    {
        $text = preg_replace($charSet, '', $text);
        return $text;
    }

    public static function filterChar($text, $charSet = self::WITHOUT_CHAR)
    {
        $text = preg_replace($charSet, '', $text);
        return $text;
    }

    public static function textToArray($text)
    {
        $text = self::removeDoubleSpace($text);
        return explode(' ', $text);
    }

    public static function mask($value, $length = 2, $valueLength = null)
    {
        if (empty($value)) {
            return '';
        }
        if ($length == 0) {
            $begin = '';
            $end = '';
        } else {
            $begin = substr($value, 0, $length);
            $end = substr($value, 0 - $length);
        }
        $valueLength = !empty($valueLength) ? $valueLength : strlen($value) - $length * 2;
        $valueLength = $valueLength > 1 ? $valueLength : 2;
        return $begin . str_repeat('*', $valueLength) . $end;
    }

    public static function extractWords($text)
    {
        $text = preg_replace('/[^0-9A-Za-zА-Яа-яЁё]/iu', ' ', $text);
        $text = self::removeDoubleSpace($text);
        $text = trim($text);
        return $text;
    }

    /**
     * @param int $length
     * @param null $set
     * @return string
     * @deprecated
     * @see RandomString
     */
    static function generateRandomString($length = 8, $set = null)
    {
        $random = new RandomString();
        if (empty($set)) {
            $set = 'num|lower|upper';
        }
        $arr = explode('|', $set);
        if (in_array('num', $arr)) {
            $random->addCharactersNumber();
        }
        if (in_array('lower', $arr)) {
            $random->addCharactersLower();
        }
        if (in_array('upper', $arr)) {
            $random->addCharactersUpper();
        }
        if (in_array('char', $arr)) {
            $random->addCharactersSpecChar();
        }
        $random->setLength($length);
        return $random->generateString();
    }
}