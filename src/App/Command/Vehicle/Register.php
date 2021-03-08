<?php

namespace FleetManager\App\Command\Vehicle;

use FleetManager\App\Query\Fleet\Get;
use FleetManager\App\Query\Vehicle\Create;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Register extends Command
{
    private $createVehicle;

    public function __construct(Create $createVehicle)
    {
        $this->createVehicle = $createVehicle;

        parent::__construct('register-vehicle');
    }

    protected function configure()
    {
        $this
            ->addArgument('fleetId', InputArgument::REQUIRED, 'The fleet ID to add to')
            ->addArgument('plateNumber', InputArgument::REQUIRED, 'The vehicle\'s plate number');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fleetId = (int) $input->getArgument('fleetId');
        $plateNumber = $input->getArgument('plateNumber');

        try {
            $vehicle = $this->createVehicle->do($fleetId, $plateNumber);
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Vehicle #'.$vehicle->getId().' succesfully registered to fleet #'.$fleetId.'!');
        return Command::SUCCESS;
    }
}