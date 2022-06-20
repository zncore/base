<?php

namespace ZnCore\Base\Libs\EventDispatcher\Interfaces;

interface EventDispatcherConfiguratorInterface
{

    public function addSubscriber($subscriberDefinition): void;
}