<?php

namespace DM\ShopmodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticlesCategories
 *
 * @ORM\Table(name="articles_categories", uniqueConstraints={@ORM\UniqueConstraint(name="Index_2", columns={"name"}), @ORM\UniqueConstraint(name="Index_3", columns={"url"})})
 * @ORM\Entity
 */
class ArticlesCategories
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=128, nullable=false)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_articles", type="smallint", nullable=false)
     */
    private $countArticles;

    /**
     * @var integer
     *
     * @ORM\Column(name="cattype_id", type="integer", nullable=true)
     */
    private $catTypeId;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ArticlesCategories
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ArticlesCategories
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set countArticles
     *
     * @param integer $countarticles
     *
     * @return ArticlesCategories
     */
    public function setCountArticles($countArticles)
    {
        $this->countArticles = $countArticles;

        return $this;
    }

    /**
     * Get countArticles
     *
     * @return integer
     */
    public function getCountArticles()
    {
        return $this->countArticles;
    }

    /**
     * Set scan
     *
     * @param string $scan
     *
     * @return ArticlesCategories
     */
    public function setScan($scan)
    {
        $this->scan = $scan;

        return $this;
    }

    /**
     * Get scan
     *
     * @return string
     */
    public function getScan()
    {
        return $this->scan;
    }


    function getCatTypeId() {
      return $this->catTypeId;
    }

     function setCatTypeId($cattype_id) {
      $this->catTypeId = $cattype_id;
    }


  // ========================================
  // ========================================

  // ========================================
}
