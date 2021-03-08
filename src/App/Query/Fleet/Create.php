<?php

namespace FleetManager\App\Query\Fleet;

use FleetManager\Domain\Model\Fleet;
use FleetManager\Infra\Repository\FleetRepository;

class Create
{
    private $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function do(int $userId): Fleet
    {
        $fleet = (new Fleet)
            ->setUserId($userId);

        $this->fleetRepository->create($fleet);

        return $fleet;
    }
}