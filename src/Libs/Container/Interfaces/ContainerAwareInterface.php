<?php

namespace ZnCore\Base\Libs\Container\Interfaces;

use Psr\Container\ContainerInterface;

\ZnCore\Base\Libs\Develop\Helpers\DeprecateHelper::hardThrow();

interface ContainerAwareInterface
{

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null);

}
