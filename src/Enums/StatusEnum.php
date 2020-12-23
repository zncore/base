<?php

//namespace Packages\Reference\Yii2\Web\Enums;
namespace ZnCore\Base\Enums;

use ZnCore\Base\Interfaces\GetLabelsInterface;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;

class StatusEnum implements GetLabelsInterface
{

    const ENABLED = 1;
    const DISABLED = 0;

    public static function getLabels()
    {
        return [
            self::ENABLED => I18Next::t('core', 'status.enabled'),
            self::DISABLED => I18Next::t('core', 'status.disabled'),
        ];
    }
}