<?php

namespace ZnCore\Base\Libs\Repository\Interfaces;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

/**
 * Возможность кодирования/декодирования данных
 * 
 * Другими словами: сериализация/десериализация данных
 *
 * @todo наследовать от:
 * @see \Symfony\Component\Serializer\Encoder\EncoderInterface
 * @see \Symfony\Component\Serializer\Encoder\DecoderInterface
 */
interface MapperInterface extends EncoderInterface
{

    /**
     * Кодирование данных
     *
     * @param array $entityAttributes Массив атрибутов сущности
     * @return array
     */
    public function encode($entityAttributes);

    /**
     * Декодирование данных
     * 
     * @param array $rowAttributes Массив атрибутов записи из БД
     * @return array
     */
    public function decode($rowAttributes);
}
