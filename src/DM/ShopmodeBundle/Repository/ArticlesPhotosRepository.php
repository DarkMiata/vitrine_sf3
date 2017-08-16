<?php

namespace DM\ShopmodeBundle\Repository;

use Doctrine\ORM\EntityRepository;
//use DM\ShopmodeBundle\Entity\ArticlesPhotos;

/**
 * Description of ArticlesPhotosRepository
 *
 * @author sam
 */
class ArticlesPhotosRepository extends EntityRepository
{

  public function findByRef($ref) {
    $photo = $this->findOneBy(array('refArticleId' => $ref));

    return $photo;
  }
  // ------------------------
  public function findPathByRef($ref) {
    $photo = $this->findOneByRefArticleId(array('refArticleId' => $ref));

    return $photo->getFileName();
  }

// ========================================
}
