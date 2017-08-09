<?php

/*
 * Controller qui permet de faire quelques tests.
 */

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use DM\ShopmodeBundle\Entity\CatType;
use DM\ShopmodeBundle\Entity\ArticlesCategories;
use AppBundle\Controller\SessionController;

use AppBundle\Service;

class DefaultController extends Controller
  {
  /**
   * @Route("/test")
   */
  public function testAction() {
    $text = "essai text";

    $testService = $this->container->get(Service\TestService::class);

    $testService->testServiceAction();

    return $this->render('DMShopmodeBundle:Default:test.html.twig', [
       'text' => $text,
    ]);
  }
  // ------------------------
  /**
   * @Route("/testcustomrepo")
   */
  public function testCustomRepoAction() {
    $catTypes = $this->getDoctrine()
        ->getRepository(CatType::class)
        ->findAllOrderedByOrdre();

    return $this->render('DMShopmodeBundle:Default:test_custom_repo.html.twig', array(
          'catTypes' => $catTypes,
    ));
  }
  // ------------------------


// ========================================
}
