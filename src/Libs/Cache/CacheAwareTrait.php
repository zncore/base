<?php

namespace ZnCore\Base\Libs\Cache;

use Symfony\Component\Cache\Adapter\AbstractAdapter;

trait CacheAwareTrait
{

    /** @var AbstractAdapter */
    protected $cache;

    public function getCache(): ?AbstractAdapter
    {
        return $this->cache;
    }

    public function setCache(AbstractAdapter $cache): void
    {
        $this->cache = $cache;
    }
}
