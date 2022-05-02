<?php

namespace ZnCore\Base\Enums;

use ZnCore\Contract\Enum\Interfaces\GetLabelsInterface;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;

class StatusSimpleEnum implements GetLabelsInterface
{

    const ENABLED = 1;
    const DISABLED = 0;
    const DELETED = self::DISABLED;

    /**
     * @deprecated
     * @see ENABLED
     */
    const ENABLE = 1;
    /**
     * @deprecated
     * @see DISABLED
     */
    const DISABLE = 0;

    public static function getLabels()
    {
        return [
            self::ENABLED => I18Next::t('core', 'status.enabled'),
            self::DISABLED => I18Next::t('core', 'status.disabled'),
        ];
    }
}