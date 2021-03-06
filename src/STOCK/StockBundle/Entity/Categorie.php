<?php

namespace STOCK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="STOCK\StockBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @ORM\ManyToOne(targetEntity="STOCK\StockBundle\Entity\Categorie")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $parentcategorie;
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
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->parentcategorie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parentcategorie = null ;
    }

    /**
     * Add parentcategorie
     *
     * @param \STOCK\StockBundle\Entity\Categorie $parentcategorie
     *
     * @return Categorie
     */
    public function addParentcategorie(\STOCK\StockBundle\Entity\Categorie $parentcategorie)
    {
        $this->parentcategorie[] = $parentcategorie;

        return $this;
    }

    /**
     * Remove parentcategorie
     *
     * @param \STOCK\StockBundle\Entity\Categorie $parentcategorie
     */
    public function removeParentcategorie(\STOCK\StockBundle\Entity\Categorie $parentcategorie)
    {
        $this->parentcategorie->removeElement($parentcategorie);
    }

    /**
     * Get parentcategorie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParentcategorie()
    {
        return $this->parentcategorie;
    }

    /**
     * Set parentcategorie
     *
     * @param \STOCK\StockBundle\Entity\Categorie $parentcategorie
     *
     * @return Categorie
     */
    public function setParentcategorie(\STOCK\StockBundle\Entity\Categorie $parentcategorie = null)
    {
        $this->parentcategorie = $parentcategorie;

        return $this;
    }
    public function getLabel()
     {
         return $this->id .', '. $this->categorie ;
       }
}
