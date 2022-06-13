<?php

namespace ZnCore\Base\Libs\Event\Interfaces;

interface EventDispatcherConfiguratorInterface
{

    public function addSubscriber($subscriberDefinition): void;
}