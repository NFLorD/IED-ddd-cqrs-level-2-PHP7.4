<?php

namespace FleetManager\Domain\Model;

use FleetManager\Domain\Value\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehicle")
 * @ORM\HasLifecycleCallbacks
 */
class Vehicle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $plateNumber;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\ManyToMany(targetEntity=Fleet::class, mappedBy="vehicles")
     */
    private $fleets;

    /**
     * Proxy to access latitude and longitude
     */
    private $location;

    public function __construct()
    {
        $this->fleets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plateNumber;
    }

    public function setPlateNumber(string $plateNumber): self
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /** 
     * @ORM\PreFlush 
     */
    public function preFlush()
    {
        if (null !== $this->location) {
            $this->latitude = $this->location->getLatitude();
            $this->longitude = $this->location->getLongitude();
        }
    }

    /**
     * @return Collection|Fleet[]
     */
    public function getFleets(): Collection
    {
        return $this->fleets;
    }

    public function addFleet(Fleet $fleet): self
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets[] = $fleet;
            $fleet->addVehicle($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): self
    {
        if ($this->fleets->removeElement($fleet)) {
            $fleet->removeVehicle($this);
        }

        return $this;
    }
}