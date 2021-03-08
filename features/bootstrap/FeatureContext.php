<?php

use Behat\Behat\Context\Context;
use FleetManager\App\Handler\VehicleParker;
use FleetManager\App\Query\AddVehicle;
use FleetManager\App\Query\GetVehicle;
use FleetManager\Domain\Model\Fleet;
use FleetManager\Domain\Model\Vehicle;
use FleetManager\Domain\Value\Location;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->vehicleParker = new VehicleParker;
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->myFleet = new Fleet;
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $vehicle = new Vehicle(new Location(43.529742, 5.447427));
        $id = (new AddVehicle)($vehicle);

        $this->aVehicle = (new GetVehicle)($id);
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->myFleet->addVehicle($this->aVehicle);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->aLocation = new Location(43.296482, 5.36978);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $this->firstParkingTryResult = $this->vehicleParker->doPark($this->aVehicle, $this->aLocation);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        assertSame(
            $this->aVehicle->getLocation(),
            $this->aLocation
        );
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->firstParkingTryResult = $this->vehicleParker->doPark($this->aVehicle, $this->aLocation);
        assertTrue($this->firstParkingTryResult);
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        $this->secondParkingTryResult = $this->vehicleParker->doPark($this->aVehicle, $this->aLocation);
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        assertFalse($this->secondParkingTryResult);
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->myFleet->addVehicle($this->aVehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        assertSame(
            $this->myFleet->getVehicle($this->aVehicle->getId()),
            $this->aVehicle
        );
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        $this->secondFleetInsertionResult = $this->myFleet->addVehicle($this->aVehicle);
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        assertFalse($this->secondFleetInsertionResult);
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->anotherUsersFleet = new Fleet;
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $this->anotherUsersFleet->addVehicle($this->aVehicle);
    }
}
