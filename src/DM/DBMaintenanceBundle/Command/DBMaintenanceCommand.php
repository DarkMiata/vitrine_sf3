<?php

namespace DM\DBMaintenanceBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DM\ShopmodeBundle\Entity\ScrapCategories;

class DBMaintenanceCommand extends Command
{
  protected function configure() {
    $this
        ->setName('app:dm-maint')
        ->setDescription('console DarkMiata')
        ->setHelp('-- controlcountcats')
        ->addArgument('commandName');
  }
  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('===== DM Maintenance Console =====');

    $command = $input->getArgument('commandName');

    switch ($command) {
      case 'controlcountcats':
        $this->controlCountCats($output);

        break;
      default:
        $output->writeln('Commande '.$command.' inconnu');
        break;
    }
  }
  // ========================================
  // ========================================

  private function controlCountCats(OutputInterface $output) {
    $output->writeln('Commande control Count Cats lancé !!');
    return;
  }
  // ------------------------

}
