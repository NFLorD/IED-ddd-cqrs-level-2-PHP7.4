<?php

namespace FleetManager\App\Query\Vehicle;

use FleetManager\App\Query\Fleet\Get;
use FleetManager\Domain\Model\Vehicle;
use FleetManager\Infra\Repository\VehicleRepository;

class Create
{
    private $vehicleRepository;
    private $getFleet;

    public function __construct(VehicleRepository $vehicleRepository, Get $getFleet)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->getFleet = $getFleet;
    }

    public function do(int $fleetId, string $plateNumber): Vehicle
    {
        if (!$fleet = $this->getFleet->do($fleetId)) {
            throw new \Exception('Fleet #'.$fleetId.' does not exist!');
        }

        if ($this->vehicleRepository->findOneBy(['plateNumber' => $plateNumber])) {
            throw new \Exception('A vehicle with license plate '.$plateNumber.' is already registered!');
        }

        $vehicle = (new Vehicle)
            ->setPlateNumber($plateNumber)
            ->addFleet($fleet);

        $this->vehicleRepository->create($vehicle);

        return $vehicle;
    }
}