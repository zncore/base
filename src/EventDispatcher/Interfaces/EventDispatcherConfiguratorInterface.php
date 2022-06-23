<?php

namespace ZnCore\Base\EventDispatcher\Interfaces;

interface EventDispatcherConfiguratorInterface
{

    public function addSubscriber($subscriberDefinition): void;
}