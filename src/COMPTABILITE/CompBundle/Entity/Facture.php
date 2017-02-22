<?php

namespace COMPTABILITE\CompBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="COMPTABILITE\CompBundle\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\ManyToOne(targetEntity="COMPTABILITE\CompBundle\Entity\Taxe")
     * @ORM\JoinColumn(nullable=true)
     */
    private $taxe;
    
    /**
     * @ORM\ManyToOne(targetEntity="CRM\CrmBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;
    
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
     * @ORM\Column(name="typepaiment", type="string", length=255)
     */
    private $typepaiment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefacture", type="date",nullable=true)
     */
    private $datefacture;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=255)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="remise", type="string", length=255,nullable=true)
     */
    private $remise;


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
     * Set typepaiment
     *
     * @param string $typepaiment
     *
     * @return Facture
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
     * Set datefacture
     *
     * @param \DateTime $datefacture
     *
     * @return Facture
     */
    public function setDatefacture($datefacture)
    {
        $this->datefacture = $datefacture;

        return $this;
    }

    /**
     * Get datefacture
     *
     * @return \DateTime
     */
    public function getDatefacture()
    {
        return $this->datefacture;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Facture
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Facture
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
     * Set status
     *
     * @param string $status
     *
     * @return Facture
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Facture
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set taxe
     *
     * @param \COMPTABILITE\CompBundle\Entity\Taxe $taxe
     *
     * @return Facture
     */
    public function setTaxe(\COMPTABILITE\CompBundle\Entity\Taxe $taxe = null)
    {
        $this->taxe = $taxe;

        return $this;
    }

    /**
     * Get taxe
     *
     * @return \COMPTABILITE\CompBundle\Entity\Taxe
     */
    public function getTaxe()
    {
        return $this->taxe;
    }

    /**
     * Set client
     *
     * @param \CRM\CrmBundle\Entity\Client $client
     *
     * @return Facture
     */
    public function setClient(\CRM\CrmBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \CRM\CrmBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set remise
     *
     * @param string $remise
     *
     * @return Facture
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return string
     */
    public function getRemise()
    {
        return $this->remise;
    }
}
