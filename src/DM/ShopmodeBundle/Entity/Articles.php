<?php

namespace DM\ShopmodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", uniqueConstraints={@ORM\UniqueConstraint(name="Index_2", columns={"name"})})
 * @ORM\Entity
 */
class Articles
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
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", length=65535, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ref", type="integer", nullable=false)
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="refsite", type="text", length=255, nullable=false)
     */
    private $refsite;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="text", length=255, nullable=false)
     */
    private $marque;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="categorie_id", type="integer", nullable=false)
     */
    private $categorieId;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_name", type="string", length=128, nullable=true)
     */
    private $catName;


    private $photo;

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
     * @return Articles
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
     * @return Articles
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
     * Set description
     *
     * @param string $description
     *
     * @return Articles
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ref
     *
     * @param integer $ref
     *
     * @return Articles
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return integer
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set refsite
     *
     * @param string $refsite
     *
     * @return Articles
     */
    public function setRefsite($refsite)
    {
        $this->refsite = $refsite;

        return $this;
    }

    /**
     * Get refsite
     *
     * @return string
     */
    public function getRefsite()
    {
        return $this->refsite;
    }

    /**
     * Set marque
     *
     * @param string $marque
     *
     * @return Articles
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Articles
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set categorieId
     *
     * @param integer $categorieId
     *
     * @return Articles
     */
    public function setCategorieId($categorieId)
    {
        $this->categorieId = $categorieId;

        return $this;
    }

    /**
     * Get categorieId
     *
     * @return integer
     */
    public function getCategorieId()
    {
        return $this->categorieId;
    }

    /**
     * Set catName
     *
     * @param string $catName
     *
     * @return Articles
     */
    public function setCatName($catName)
    {
        $this->catName = $catName;

        return $this;
    }

    /**
     * Get catName
     *
     * @return string
     */
    public function getCatName()
    {
        return $this->catName;
    }


    public function getPhoto() {
      return $this->photo;
    }
    public function setPhoto($photo) {
      $this->photo = $photo;
    }


}

