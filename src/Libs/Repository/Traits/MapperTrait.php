<?php

namespace ZnCore\Base\Libs\Repository\Traits;

use Illuminate\Support\Collection;
use ZnCore\Base\Encoders\AggregateEncoder;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\Inflector;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Base\Libs\Entity\Interfaces\EntityIdInterface;

trait MapperTrait
{

    public function mappers(): array
    {
        return [

        ];
    }

    protected function underscore(array $attributes, array $columnList = [])
    {
        $arraySnakeCase = [];
        foreach ($attributes as $name => $value) {
            $tableizeName = Inflector::underscore($name);
            $arraySnakeCase[$tableizeName] = $value;
        }
        if ($columnList) {
            $arraySnakeCase = ArrayHelper::extractByKeys($arraySnakeCase, $columnList);
        }
        return $arraySnakeCase;
    }

    protected function mapperEncodeEntity(EntityIdInterface $entity): array
    {
        $attributes = EntityHelper::toArray($entity);
        $attributes = $this->underscore($attributes);
        $mappers = $this->mappers();
        if ($mappers) {
            $encoders = new AggregateEncoder(new Collection($mappers));
            $attributes = $encoders->encode($attributes);
        }
        $columnList = $this->getColumnsForModify();
        $attributes = ArrayHelper::extractByKeys($attributes, $columnList);
        return $attributes;
    }

    protected function mapperDecodeEntity(array $array): object
    {
        $mappers = $this->mappers();
        if ($mappers) {
            $mappers = array_reverse($mappers);
            $encoders = new AggregateEncoder(new Collection($mappers));
            $array = $encoders->decode($array);
        }
        $entity = ClassHelper::createInstance($this->getEntityClass());
        EntityHelper::setAttributes($entity, $array);
        return $entity;
    }

    protected function mapperDecodeCollection(array $array): Collection
    {
        $collection = new Collection();
        foreach ($array as $item) {
            $entity = $this->mapperDecodeEntity((array)$item);
            $collection->add($entity);
        }
        return $collection;
    }
}