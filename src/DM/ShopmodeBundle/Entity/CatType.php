<?php

namespace DM\ShopmodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatType
 *
 * @ORM\Table(name="cat_type")
 * @ORM\Entity(repositoryClass="DM\ShopmodeBundle\Repository\CatTypeRepository")
 */
class CatType
  {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="nom", type="string", length=64, unique=false)
   */
  private $nom;

  /**
   * @var int
   *
   * @ORM\Column(name="ordre", type="integer", unique=false)
   */
  private $ordre;

  /**
   * Get id
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }
  /**
   * Set nom
   *
   * @param string $nom
   *
   * @return CatType
   */
  public function setNom($nom) {
    $this->nom = $nom;

    return $this;
  }
  /**
   * Get nom
   *
   * @return string
   */
  public function getNom() {
    return $this->nom;
  }
  /**
   * Set ordre
   *
   * @param integer $ordre
   *
   * @return CatType
   */
  public function setOrdre($ordre) {
    $this->ordre = $ordre;

    return $this;
  }
  /**
   * Get ordre
   *
   * @return int
   */
  public function getOrdre() {
    return $this->ordre;
  }

// ========================================
}
