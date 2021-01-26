<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

class ExampleCachedLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $loaderCallback = function () use ($bundles) {

            return $config;
        };
        $config = $this->loadFromCache($loaderCallback);
        return $config;
    }
}
