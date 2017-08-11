<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DM\ShopmodeBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DM\ShopmodeBundle\Controller\ShopController;

/**
 * Description of ArticlesRepository
 *
 * @author sam
 */
class ArticlesRepository extends EntityRepository
{

  public function countByCat(string $cat) {
    $count = $this
        ->createQueryBuilder('a')
        ->select('COUNT(a)')
        ->where('a.catName = :cat')
        ->setparameter('cat', $cat)
        ->getQuery()
        ->getSingleScalarResult();

    return $count;
  }
  // ------------------------
  public function findByPage($indexPage, $catName) {
        $articles = $this->findby(
        ['catName' => $catName],
            ['id' => 'asc'],
            ShopController::ARTICLE_PAR_PAGE, // constante de shopController
            $indexPage
    );

    return $articles;
  }

// ========================================
}
