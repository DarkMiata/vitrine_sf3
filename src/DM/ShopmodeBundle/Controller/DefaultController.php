<?php

/*
 * Controller qui permet de faire quelques tests.
 */

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use DM\ShopmodeBundle\Entity\CatType;
use DM\ShopmodeBundle\Entity\ScrapCategories;

class DefaultController extends Controller
  {
  /**
   * @Route("/test")
   */
  public function testAction() {
    $catTypes = $this->getDoctrine()->getRepository(CatType::class)
        ->findAllOrderedByOrdre();

    foreach ($catTypes as $catType) {
      $catTypeId = $catType->getId();

      $categories = $this->getDoctrine()->getRepository(ScrapCategories::class)
          ->findByCatTypeId($catTypeId);

      $menu[] = array(
        'catTypeName' => $catType->getNom(),
        'cats'        => $categories
      );
    }

    var_dump($menu);

    return $this->render('DMShopmodeBundle:Default:test.html.twig', [
          'menu' => $menu,
    ]);
  }
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
// ========================================
}
