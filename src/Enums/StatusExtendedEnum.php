<?php

namespace ZnCore\Base\Enums;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;

class StatusExtendedEnum
{

    // удален
    const DELETED = -10;

    // отключен
    const DISABLE = 0;

    // отвергнут / отклонен
    const REJECTED = 10;

    // заблокирован
    const BLOCKED = 20;

    // ожидает одобрения / премодерация
    const WAIT_APPROVING = 90;

    // включен / одобрен
    const ENABLE = 100;

    // обработано / завершено
    const COMPLETED = 200;

    public static function getLabels()
    {
        return [
            self::ENABLED => I18Next::t('app', 'status.enabled'),
            self::DISABLED => I18Next::t('app', 'status.disabled'),
        ];
    }
}
