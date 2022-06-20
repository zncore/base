<?php

namespace ZnCore\Base\Enums;

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Base\Libs\Enum\Interfaces\GetLabelsInterface;

/**
 * Статусы сущности
 */
class StatusEnum implements GetLabelsInterface
{

    // удален
    const DELETED = -10;

    // отключен
    const DISABLED = 0;

    // отвергнут / отклонен
    const REJECTED = 10;

    // заблокирован
    const BLOCKED = 20;

    // ожидает одобрения / премодерация
    const WAIT_APPROVING = 90;

    // включен / одобрен
    const ENABLED = 100;

    // обработано / завершено
    const COMPLETED = 200;

    public static function getLabels()
    {
        return [
            self::DELETED => I18Next::t('core', 'status.deleted'),
            self::DISABLED => I18Next::t('core', 'status.disabled'),
            self::REJECTED => I18Next::t('core', 'status.rejected'),
            self::BLOCKED => I18Next::t('core', 'status.blocked'),
            self::WAIT_APPROVING => I18Next::t('core', 'status.wait_approving'),
            self::ENABLED => I18Next::t('core', 'status.enabled'),
            self::COMPLETED => I18Next::t('core', 'status.completed'),
        ];
    }
}
