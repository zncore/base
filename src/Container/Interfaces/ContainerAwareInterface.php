<?php

namespace ZnCore\Base\Container\Interfaces;

use Psr\Container\ContainerInterface;

\ZnCore\Base\Develop\Helpers\DeprecateHelper::hardThrow();

interface ContainerAwareInterface
{

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null);

}
