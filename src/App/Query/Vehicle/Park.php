<?php

namespace FleetManager\App\Query\Vehicle;

use FleetManager\App\Query\Fleet\Get;
use FleetManager\Domain\Model\Vehicle;
use FleetManager\Domain\Value\Location;
use FleetManager\Infra\Repository\VehicleRepository;

class Park
{
    private $vehicleRepository;
    private $getFleet;

    public function __construct(VehicleRepository $vehicleRepository, Get $getFleet)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->getFleet = $getFleet;
    }

    public function do(int $fleetId, string $plateNumber, float $latitude, float $longitude): Vehicle
    {
        if (!$fleet = $this->getFleet->do($fleetId)) {
            throw new \Exception('Fleet #'.$fleetId.' does not exist!');
        }

        if (!$vehicle = $this->vehicleRepository->findOneBy(['plateNumber' => $plateNumber])) {
            throw new \Exception('Such a license plate '.$plateNumber.' does not exist!');
        }

        if (!$vehicle->getFleets()->contains($fleet)) {
            throw new \Exception('The vehicle with license plate '.$plateNumber.' is not in fleet #'.$fleetId.'!');
        }

        $vehicle->setLocation(new Location($latitude, $longitude));
        $this->vehicleRepository->update($vehicle);

        return $vehicle;
    }
}