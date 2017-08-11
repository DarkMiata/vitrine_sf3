<?php

namespace DM\ShopmodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use DM\ShopmodeBundle\Entity\ArticlesCategories;
use DM\ShopmodeBundle\Entity\Articles;
use DM\ShopmodeBundle\Entity\CatType;

/*
 * Génération du menu - affichage des catégories.
 */

class NavbarController extends Controller
{
  // Génération de la navbar.
  public function NavbarAction() {
    $menu = $this->CategoriesMenuDropdown();

    $user = $this->get('security.token_storage')->getToken()->getUser();

    $artQuant = 0;

    // si utilisateur est anonyme, quantité article = 0
    if ($user == 'anon.') { $artQuant = 0; }

    return $this->render('navbar/shop_navbar.html.twig', [
      'menu'            => $menu,
      'articleQuantity' => $artQuant,
      'user'            => $user,
    ]);
  }
  // ------------------------
  // Génération de la dropdown des catégories
  private function CategoriesMenuDropdown() {
      $catTypes = $this->getDoctrine()->getRepository(CatType::class)
    ->findAllOrderedByOrdre();

    foreach ($catTypes as $catType) {
      $catTypeId = $catType->getId();

      $categories = $this->getDoctrine()->getRepository(ArticlesCategories::class)
          ->findByCatTypeId($catTypeId);

      $menu[] = array(
        'catTypeName' => $catType->getNom(),
        'cats'        => $categories
      );
    }

    return $menu;
  }
// ========================================
// ========================================

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
      $repository = $em->getRepository('DMShopmodeBundle:Articles');

      //var_dump($cat);

      //echo $cat->getName();

      $countArticlesByCat = $repository
          ->createQueryBuilder('a')
          ->select('COUNT(a)')
          ->where('a.catName = :cat')
          ->setparameter('cat', $cat->getName())
          ->getQuery()
          ->getSingleScalarResult();

      if ($countArticlesByCat === $cat->getCountArticles()) {

      }
      else {
//        $this->get('logger')->error('article trouvé dans DB: '.$countArticlesByCat
//            .' - Articles sauvegardé dans catégorie:'. $cat->getCountarticles());

        $cat->setCountArticles($countArticlesByCat);

      }
    }
  }
}