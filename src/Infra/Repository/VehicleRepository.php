<?php

namespace FleetManager\Infra\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use FleetManager\Domain\Model\Vehicle;

class VehicleRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getClassMetadata(Vehicle::class));
    }

    public function create(Vehicle $vehicle)
    {
        $this->_em->persist($vehicle);
        $this->_em->flush();
    }

    public function update(Vehicle $vehicle)
    {
        $this->_em->flush();
    }
}