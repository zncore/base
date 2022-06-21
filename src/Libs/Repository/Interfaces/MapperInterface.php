<?php

namespace ZnCore\Base\Libs\Repository\Interfaces;

/**
 * Возможность кодирования/декодирования данных
 * 
 * Другими словами: сериализация/десериализация данных
 *
 * @todo наследовать от:
 * @see \Symfony\Component\Serializer\Encoder\EncoderInterface
 * @see \Symfony\Component\Serializer\Encoder\DecoderInterface
 */
interface MapperInterface
{

    /**
     * Кодирование данных
     *
     * @param mixed $data Исходные данные
     * @return mixed
     */
    public function encode(object $data): array;

    /**
     * Декодирование данных
     * 
     * @param mixed $encodedData Закодированные данные
     * @return mixed
     */
    public function decode($encodedData);
}
