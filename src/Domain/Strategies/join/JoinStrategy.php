<?php

namespace ZnCore\Base\Domain\Strategies\join;

use Illuminate\Support\Collection;
use ZnCore\Base\Domain\Dto\WithDto;
use ZnCore\Base\Domain\Entities\relation\RelationEntity;
use ZnCore\Base\Domain\Enums\RelationEnum;
use ZnCore\Base\Domain\Strategies\join\handlers\Callback;
use ZnCore\Base\Domain\Strategies\join\handlers\HandlerInterface;
use ZnCore\Base\Domain\Strategies\join\handlers\Many;
use ZnCore\Base\Domain\Strategies\join\handlers\ManyToMany;
use ZnCore\Base\Domain\Strategies\join\handlers\One;
use ZnCore\Base\Patterns\Strategy\Base\BaseStrategyContextHandlers;

/**
 * Class PaymentStrategy
 *
 * @package ZnCore\Base\Domain\Strategies\payment
 *
 * @property-read HandlerInterface $strategyInstance
 */
class JoinStrategy extends BaseStrategyContextHandlers
{

    public function getStrategyDefinitions()
    {
        return [
            RelationEnum::ONE => One::class,
            RelationEnum::MANY => Many::class,
            RelationEnum::MANY_TO_MANY => ManyToMany::class,
            RelationEnum::CALLBACK => Callback::class,
        ];
    }

    public function load($entity, WithDto $w, $relCollection): RelationEntity
    {
        return $this->getStrategyInstance()->load($entity, $w, $relCollection);
    }

    public function join(Collection $collection, RelationEntity $relationEntity)
    {
        if (empty($collection)) {
            return null;
        }
        return $this->getStrategyInstance()->join($collection, $relationEntity);
    }

}