<?php

namespace ZnCore\Base\Patterns\Strategy\Base;

/**
 * Class BaseStrategyContext
 *
 * @package ZnCore\Base\Libs\Scenario\Base
 *
 * @property-read Object $strategyInstance
 */
abstract class BaseStrategyContext
{

    private $strategyInstance;

    public function __construct(object $strategyInstance = null)
    {
        $this->strategyInstance = $strategyInstance;
    }

    protected function getStrategyInstance()
    {
        return $this->strategyInstance;
    }

    protected function setStrategyInstance($strategyInstance)
    {
        $this->strategyInstance = $strategyInstance;
    }

}
