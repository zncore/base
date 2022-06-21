<?php

namespace ZnCore\Base\Libs\Repository\Mappers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Repository\Interfaces\MapperInterface;

class PathMapper implements MapperInterface
{

    private $map;
    private $isRemoveOldValue;

    public function __construct(array $map, bool $isRemoveOldValue = true)
    {
        $this->map = $map;
        $this->isRemoveOldValue = $isRemoveOldValue;
    }

    public function encode($data)
    {
        return $data;
    }

    public function decode($row)
    {
        foreach ($this->map as $toPath => $fromPath) {
            $value = ArrayHelper::getValue($row, $fromPath);
            ArrayHelper::setValue($row, $toPath, $value);
            if ($this->isRemoveOldValue) {
                ArrayHelper::removeItem($row, $fromPath);
            }
        }
        return $row;
    }
}
