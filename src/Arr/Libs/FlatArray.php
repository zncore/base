<?php

namespace ZnCore\Base\Arr\Libs;

use ZnCore\Base\Arr\Helpers\ArrayHelper;

class FlatArray
{

    public function encode(array $array, string $prefixKey = null, &$result = []): array
    {
        foreach ($array as $key => $value) {
            if ($prefixKey) {
                $key = $prefixKey . '.' . $key;
            }
            if (is_array($value)) {
                $this->encode($value, $key, $result);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    function decode(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            ArrayHelper::setValue($result, $key, $value);
        }
        return $result;
    }
}
