<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DM\ShopmodeBundle\Entity\ScrapCategories;
use DM\ShopmodeBundle\Entity\ScrapArticles;

/*
 * Génération du menu - affichage des catégories.
 */

class MenuController extends Controller
{
  public function menuAction() {
    $allcats = $this->findAllCategories();

    $user = $this->get('security.token_storage')->getToken()->getUser();

    // !!! temporaire, test d'affichage 10 articles dans panier
    $artQuant = 10;

    // si utilisateur est anonyme, quantité article = 0
    if ($user == 'anon.') { $artQuant = 0; }

//    return $this->render('menu/large_drop_dropdown_menu.html.twig', [
//      'cats'            => $allcats,
//      'articleQuantity' => $artQuant,
//    ]);

    return $this->render('menu/menu_DM.html.twig', [
      'cats'            => $allcats,
      'articleQuantity' => $artQuant,
    ]);
  }
// ========================================
// ========================================
  private function generateWebspage() {
  }

  // ------------------------
  // Renvoi la liste de toutes les catégories
  private function findAllCategories() {
    $em = $this->getDoctrine()->getManager();

    $allCats = $em->getRepository('DMShopmodeBundle:ScrapCategories')
        ->findAll();

    $this->controlCountCategories($allCats);

    return $allCats;
  }
  // ------------------------
  private function controlCountCategories(array $cats) {
    foreach ($cats as $cat) {
      $em         = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('DMShopmodeBundle:ScrapArticles');

      //var_dump($cat);

      //echo $cat->getName();

      $countArticlesByCat = $repository
          ->createQueryBuilder('a')
          ->select('COUNT(a)')
          ->where('a.catName = :cat')
          ->setparameter('cat', $cat->getName())
          ->getQuery()
          ->getSingleScalarResult();

      if ($countArticlesByCat === $cat->getCountarticles()) {

      }
      else {
//        $this->get('logger')->error('article trouvé dans DB: '.$countArticlesByCat
//            .' - Articles sauvegardé dans catégorie:'. $cat->getCountarticles());

        $cat->setCountarticles($countArticlesByCat);

      }
    }
  }
}
