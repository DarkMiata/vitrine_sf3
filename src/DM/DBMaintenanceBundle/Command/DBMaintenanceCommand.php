<?php

namespace DM\DBMaintenanceBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DM\ShopmodeBundle\Entity\ScrapCategories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Custom services
//use DM\ScrapBundle\Service\Files;
// Permet d'utiliser Doctrine dans la command console
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DBMaintenanceCommand extends ContainerAwareCommand
{
  protected function configure() {
    $this
        ->setName('app:dm-maint')
        ->setDescription('console DarkMiata')
        ->setHelp('-- controlcountcats')
        ->addArgument('commandName')
        ->addArgument('args', \Symfony\Component\Console\Input\InputArgument::OPTIONAL);
  }
  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('===== DM Maintenance Console =====');

    $command = $input->getArgument('commandName');

    switch ($command) {
      case 'controlcountcats':
        $arg = $input->getArgument('args');
        $this->controlCountCatsCommand($output, $arg);
      break;

      case 'help':
        $this->helpCommand($output);
      break;

      case 'test':
        $this->testCommand($output);
      break;

      default:
        $output->writeln('Commande '.$command.' inconnu');
      break;
    }
  }
  // ========================================
  // ========================================

  private function helpCommand(OutputInterface $output) {
    $output->writeln('Command help - essai');

    return;
  }
  // ------------------------
  private function controlCountCatsCommand(OutputInterface $output, $arg) {
    $countCat = $this->countArticlesByCat($arg);

    $output->writeln([
      'Commande control Count Cats lance !!',
      'categorie: '.$arg,
      'nombre d articles dans la categorie: '.$countCat,
      ]);

    return;
  }
  // ------------------------
    private function testCommand(OutputInterface $output) {
      $FileService = new Files();

      $FileService->loadAndSaveHTML(
          'https://symfony.com/doc/3.4/service_container.html',
          'd:',
          FALSE);

      return;
    }

  // ========================================
  // ========================================

  private function countArticlesByCat($cat) {
    $doctrine = $this->getContainer()->get('doctrine');
    $em = $doctrine->getEntityManager();

    $repository = $em->getRepository('DMShopmodeBundle:ScrapArticles');

    $count = $repository
        ->createQueryBuilder('a')
        ->select('COUNT(a)')
        ->where('a.catName = :cat')
        ->setparameter('cat', $cat)
        ->getQuery()
        ->getSingleScalarResult();

    return $count;
  }

// ----------------------


}