<?php

namespace COMPTABILITE\CompBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paiment
 *
 * @ORM\Table(name="paiment")
 * @ORM\Entity(repositoryClass="COMPTABILITE\CompBundle\Repository\PaimentRepository")
 */
class Paiment
{
    /**
     * @ORM\ManyToOne(targetEntity="CRM\CrmBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

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
     * @ORM\Column(name="typepaiement", type="string", length=255)
     */
    private $typepaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="string", length=255)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepayment", type="date")
     */
    private $datepayment;

    

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


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
     * Set typepaiement
     *
     * @param string $typepaiement
     *
     * @return paiment
     */
    public function setTypepaiement($typepaiement)
    {
        $this->typepaiement = $typepaiement;

        return $this;
    }

    /**
     * Get typepaiement
     *
     * @return string
     */
    public function getTypepaiement()
    {
        return $this->typepaiement;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return paiment
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set datepayment
     *
     * @param \DateTime $datepayment
     *
     * @return paiment
     */
    public function setDatepayment($datepayment)
    {
        $this->datepayment = $datepayment;

        return $this;
    }

    /**
     * Get datepayment
     *
     * @return \DateTime
     */
    public function getDatepayment()
    {
        return $this->datepayment;
    }

    /**
     * Set proprietaire
     *
     * @param string $proprietaire
     *
     * @return paiment
     */
    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return string
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return paiment
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
     * Set fournisseur
     *
     * @param \STOCK\StockBundle\Entity\Fournisseur $fournisseur
     *
     * @return Paiment
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

    /**
     * Set client
     *
     * @param \Crm\CrmBundle\Entity\Client $client
     *
     * @return Paiment
     */
    public function setClient(\Crm\CrmBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Crm\CrmBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
