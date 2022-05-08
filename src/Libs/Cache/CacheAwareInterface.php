<?php

namespace ZnCore\Base\Libs\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use ZnCore\Base\Helpers\DeprecateHelper;

DeprecateHelper::hardThrow();

interface CacheAwareInterface
{

    public function getCache(): ?AdapterInterface;

    public function setCache(AdapterInterface $cache): void;
}
