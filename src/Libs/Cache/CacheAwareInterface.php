<?php

namespace ZnCore\Base\Libs\Cache;

use Symfony\Component\Cache\Adapter\AbstractAdapter;

interface CacheAwareInterface
{

    public function getCache(): ?AbstractAdapter;

    public function setCache(AbstractAdapter $cache): void;
}
