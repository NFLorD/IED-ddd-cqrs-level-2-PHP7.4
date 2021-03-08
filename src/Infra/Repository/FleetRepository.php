<?php

namespace FleetManager\Infra\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use FleetManager\Domain\Model\Fleet;

class FleetRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getClassMetadata(Fleet::class));
    }

    public function create(Fleet $fleet)
    {
        $this->_em->persist($fleet);
        $this->_em->flush();
    }
}