<?php

namespace ZnCore\Base\Libs\App\Libs\EnvDetector;

use ZnCore\Base\Libs\Code\InstanceResolver;

class EnvDetector
{

    private $drivers = [
        ConsoleEnvDetector::class,
        WebEnvDetector::class,
    ];

    public function isTest(): bool
    {
        $driver = $this->getDriverInstance();
        return $driver->isTest();
    }

    protected function getDriverInstance(): EnvDetectorInterface
    {
        foreach ($this->drivers as $driverDefinition) {
            $instanceResolver = new InstanceResolver();
            /** @var EnvDetectorInterface $driver */
            $driver = $instanceResolver->ensure($driverDefinition);
            if ($driver->isMatch()) {
                return $driver;
            }
        }
        throw new \Exception('Driver not found for current env!');
    }
}
