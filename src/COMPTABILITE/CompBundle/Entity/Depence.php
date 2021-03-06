<?php

namespace COMPTABILITE\CompBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depence
 *
 * @ORM\Table(name="depence")
 * @ORM\Entity(repositoryClass="COMPTABILITE\CompBundle\Repository\DepenceRepository")
 */
class Depence
{
    /**
     * @ORM\ManyToOne(targetEntity="STOCK\StockBundle\Entity\Fournisseur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $fournisseur;
    
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
     * @ORM\Column(name="valeur", type="string", length=255)
     */
    private $valeur;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="string", length=255)
     */
    private $remarque;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="typepaiment", type="string", length=255)
     */
    private $typepaiment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedepence", type="date")
     */
    private $datedepence;


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
     * Set valeur
     *
     * @param string $valeur
     *
     * @return Depence
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Depence
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Depence
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set datedepence
     *
     * @param \DateTime $datedepence
     *
     * @return Depence
     */
    public function setDatedepence($datedepence)
    {
        $this->datedepence = $datedepence;

        return $this;
    }

    /**
     * Get datedepence
     *
     * @return \DateTime
     */
    public function getDatedepence()
    {
        return $this->datedepence;
    }

    /**
     * Set typepaiment
     *
     * @param string $typepaiment
     *
     * @return Depence
     */
    public function setTypepaiment($typepaiment)
    {
        $this->typepaiment = $typepaiment;

        return $this;
    }

    /**
     * Get typepaiment
     *
     * @return string
     */
    public function getTypepaiment()
    {
        return $this->typepaiment;
    }

    /**
     * Set fournisseur
     *
     * @param \STOCK\StockBundle\Entity\Fournisseur $fournisseur
     *
     * @return Depence
     */
    public function setFournisseur(\STOCK\StockBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \STOCK\StockBundle\Entity\Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
}
