<?php

namespace FleetManager\App\Handler;

use FleetManager\Domain\Model\Vehicle;
use FleetManager\Domain\Value\Location;

class VehicleParker
{
    public function doPark(Vehicle $vehicle, Location $location)
    {
        if ($vehicle->getLocation() === $location) {
            return false;
        }

        $vehicle->setLocation($location);
        return true;
    }
}