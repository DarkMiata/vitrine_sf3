<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DM\ShopmodeBundle\Entity\ScrapCategories;

/*
 * Génération du menu - affichage des catégories.
 */

class MenuController extends Controller
{
  public function menuAction() {
    $allcats = $this->findAllCategories();

    return $this->render('menu/large_drop_dropdown_menu.html.twig', [
      'cats' => $allcats,
    ]);
  }
// ========================================
// ========================================
  // Renvoi la liste de toutes les catégories
  private function findAllCategories() {
    $em = $this->getDoctrine()->getManager();

    $allCats = $em->getRepository('DMShopmodeBundle:ScrapCategories')
        ->findAll();

    return $allCats;
  }

}
