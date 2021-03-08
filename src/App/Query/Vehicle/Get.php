<?php

namespace FleetManager\App\Query\Vehicle;

use FleetManager\Domain\Model\Vehicle;
use FleetManager\Infra\Repository\VehicleRepository;

class Get
{
    private $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function do(int $id): Vehicle
    {
        return $this->vehicleRepository->findOneBy(['id' => $id]);
    }
}