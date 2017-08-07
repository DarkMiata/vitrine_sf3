<?php

namespace DM\ShopmodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
// ------------------------
use DM\ShopmodeBundle\Entity\CatType;
use DM\ShopmodeBundle\Repository\CatTypeRepository;
use Doctrine;

class ShopRepositoryCommand extends ContainerAwareCommand
  {
  protected function configure() {
    $this
        ->setName('shop:repository')
        ->setDescription('...')
        ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
        ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
    ;
  }
  protected function execute(InputInterface $input, OutputInterface $output) {
    $argument = $input->getArgument('argument');

    if ($input->getOption('option')) {
      // ...
    }

    switch ($argument) {
      case 'findall':
        self::echln('commande findAll');
        self::findAllCattypesOrderedByOrdreAction();
        break;
    }

//    $output->writeln('Command result.');
  }
// ========================================
  private function findAllCattypesOrderedByOrdreAction() {
    self::echln('Command find all ordered by "ordre"');

//    $catTypes = $this->getContainer()->getDoctrine()
//        ->getrepository('DMShopmodeBundle:CatType')
//        ->findAllOrderedByOrdre();

    var_dump($catTypes);
  }
  // ------------------------
  private function echln($text) {
    echo ($text . "\n");
  }
// ========================================
  }
