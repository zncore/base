<?php

use ZnCore\Base\Libs\Container\Libs\BundleLoaders\ContainerLoader;
use ZnCore\Base\Libs\I18Next\Libs\BundleLoaders\I18NextLoader;
use ZnDatabase\Migration\Domain\Libs\BundleLoaders\MigrationLoader;
use ZnUser\Rbac\Domain\Libs\BundleLoaders\RbacConfigLoader;

return [
    'container' => ContainerLoader::class,
    'i18next' => I18NextLoader::class,
    'rbac' => RbacConfigLoader::class,
    'migration' => MigrationLoader::class,
];
