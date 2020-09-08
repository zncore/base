<?php

namespace ZnCore\Base\Helpers;

use DateTime;
use DateTimeZone;
use ZnCore\Base\Exceptions\InvalidArgumentException;

class TimeHelper
{

    public static function unserialize($data): DateTime
    {
        if(is_array($data) && !empty($data['timezone']) && !empty($data['date'])) {
            return self::unserializeFromArray($data);
        } elseif($data instanceof DateTime) {
            return $data;
        }
        throw new InvalidArgumentException;
    }

    public static function unserializeFromArray(array $data): DateTime
    {
        $timeZone = new DateTimeZone($data['timezone']);
        return new DateTime($data['date'], $timeZone);
    }

}
