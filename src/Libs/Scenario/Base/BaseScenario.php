<?php

namespace ZnCore\Base\Libs\Scenario\Base;

use ZnCore\Base\Libs\Scenario\Interfaces\RunInterface;

abstract class BaseScenario implements RunInterface
{

    private $data;
    public $event;
    public $isEnabled = true;

    public function isEnabled()
    {
        return $this->isEnabled;
    }

    public function setData($value)
    {
        $this->data = $value;
    }

    public function issetData()
    {
        return isset($this->data);
    }

    public function getData()
    {
        return $this->data;
    }

}
