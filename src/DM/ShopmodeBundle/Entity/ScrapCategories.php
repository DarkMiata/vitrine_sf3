<?php

namespace DM\ShopmodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ScrapCategories
 *
 * @ORM\Table(name="scrap_categories", uniqueConstraints={@ORM\UniqueConstraint(name="Index 2", columns={"name"}), @ORM\UniqueConstraint(name="Index 3", columns={"url"})})
 * @ORM\Entity
 */
class ScrapCategories
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
     * @ORM\Column(name="countArticles", type="smallint", nullable=false)
     */
    private $countarticles;

    /**
     * @var string
     *
     * @ORM\Column(name="scan", type="text", length=255, nullable=true)
     */
    private $scan;



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
     * @return ScrapCategories
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
     * @return ScrapCategories
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
     * Set countarticles
     *
     * @param integer $countarticles
     *
     * @return ScrapCategories
     */
    public function setCountarticles($countarticles)
    {
        $this->countarticles = $countarticles;

        return $this;
    }

    /**
     * Get countarticles
     *
     * @return integer
     */
    public function getCountarticles()
    {
        return $this->countarticles;
    }

    /**
     * Set scan
     *
     * @param string $scan
     *
     * @return ScrapCategories
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
}
