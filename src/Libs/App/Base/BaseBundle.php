<?php

namespace ZnCore\Base\Libs\App\Base;

abstract class BaseBundle
{

    private $importList;

    /**
     * Зависимости (бандлы)
     * @return array
     */
    public function deps(): array
    {
        return [];
    }

    /**
     * Что импортировать из бандлов:
     *
     * i18next - переводы в формате I18Next
     * container - конфигурация контейнера (DI)
     * rbac - конфигурация ролей, полномочий, наследования RBAC
     * symfonyRpc - RPC-роуты
     * migration - миграции БД
     * console - команды консоли
     * telegramRoutes - роуты для Telegram-бота
     * symfonyAdmin - роуты админки
     * symfonyWeb - роуты пользовательской части
     *
     * @return array
     */
    public function getImportList(): array
    {
        return $this->importList;
    }

    /**
     *
     * @param array $importList
     */
    public function __construct(array $importList = [])
    {
        $this->importList = $importList;
    }

    /**
     * команды консоли
     * @return array
     */
    public function console(): array
    {
        return [];
    }

    /**
     * конфигурация контейнера (DI)
     * @return array
     */
    public function container(): array
    {
        return [];
    }

    /**
     * конфигурация ролей, полномочий, наследования RBAC
     * @return array
     */
    public function rbac(): array
    {
        return [];
    }
}
