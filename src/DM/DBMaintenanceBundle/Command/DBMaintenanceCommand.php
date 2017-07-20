<?php

namespace DM\DBMaintenanceBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DBMaintenanceCommand extends Command
  {
  protected function configure() {
    $this
        ->setName('app:dm_maint')
        ->setDescription('console DarkMiata')
        ->setHelp('??');
  }
  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('<info>Hello World !!</info>');
  }
  }
