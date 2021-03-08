<?php

namespace FleetManager\App\Command\Fleet;

use FleetManager\App\Query\Fleet\Create as CreateFleet;
use FleetManager\Domain\Model\Fleet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends Command
{
    private $createFleet;

    public function __construct(CreateFleet $createFleet)
    {
        $this->createFleet = $createFleet;

        parent::__construct('create');
    }

    protected function configure()
    {
        $this->addArgument('userId', InputArgument::REQUIRED, 'User ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userId = (int) $input->getArgument('userId');

        try {
            $fleet = $this->createFleet->do($userId);
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Fleet #'.$fleet->getId().' succesfully created!');
        return Command::SUCCESS;
    }
}