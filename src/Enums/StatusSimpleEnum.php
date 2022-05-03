<?php

namespace ZnCore\Base\Enums;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Contract\Enum\Interfaces\GetLabelsInterface;

class StatusSimpleEnum implements GetLabelsInterface
{

    const ENABLED = 1;
    const DISABLED = 0;
    const DELETED = self::DISABLED;

    public static function getLabels()
    {
        return [
            self::ENABLED => I18Next::t('core', 'status.enabled'),
            self::DISABLED => I18Next::t('core', 'status.disabled'),
        ];
    }
}