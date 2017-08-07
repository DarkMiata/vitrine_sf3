<?php

namespace DM\ShopmodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlzPhotos
 *
 * @ORM\Entity
 */
class BlzPhotos
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
     * @var integer
     *
     * @ORM\Column(name="ref_article", type="integer", nullable=false)
     */
    private $refArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="text", length=65535, nullable=false)
     */
    private $fileName;



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
     * Set refArticle
     *
     * @param integer $refArticle
     *
     * @return BlzPhotos
     */
    public function setRefArticle($refArticle)
    {
        $this->refArticle = $refArticle;

        return $this;
    }

    /**
     * Get refArticle
     *
     * @return integer
     */
    public function getRefArticle()
    {
        return $this->refArticle;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return BlzPhotos
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
