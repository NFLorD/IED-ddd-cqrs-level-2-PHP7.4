<?php

namespace FleetManager\App\Query\Fleet;

use FleetManager\Domain\Model\Fleet;
use FleetManager\Infra\Repository\FleetRepository;

class Get
{
    private $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function do(int $id): Fleet
    {
        return $this->fleetRepository->findOneBy(['id' => $id]);
    }
}