<?php

namespace FleetManager\App\Command\Vehicle;

use FleetManager\App\Query\Vehicle\Park;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Localize extends Command
{
    private $parkVehicle;

    public function __construct(Park $parkVehicle)
    {
        $this->parkVehicle = $parkVehicle;

        parent::__construct('localize-vehicle');
    }

    protected function configure()
    {
        $this
            ->addArgument('fleetId', InputArgument::REQUIRED, 'The fleet ID to add to')
            ->addArgument('plateNumber', InputArgument::REQUIRED, 'The vehicle\'s plate number')
            ->addArgument('latitude', InputArgument::REQUIRED, 'The vehicle\'s latitude')
            ->addArgument('longitude', InputArgument::REQUIRED, 'The vehicle\'s longitude')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fleetId = (int) $input->getArgument('fleetId');
        $plateNumber = $input->getArgument('plateNumber');
        $latitude = (float) $input->getArgument('latitude');
        $longitude = (float) $input->getArgument('longitude');

        try {
            $vehicle = $this->parkVehicle->do($fleetId, $plateNumber, $latitude, $longitude);
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Vehicle #'.$vehicle->getId().' succesfully parked to '.$latitude.', '.$longitude.'!');
        return Command::SUCCESS;
    }
}