<?php

namespace STOCK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="STOCK\StockBundle\Repository\CommandeRepository")
 */
class Commande
{
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
     * @ORM\Column(name="montans", type="string", length=255, nullable=true)
     */
    private $montans;

    /**
     * @var string
     *
     * @ORM\Column(name="typelivraison", type="string", length=255, nullable=true)
     */
    private $typelivraison;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateajout", type="date", nullable=true)
     */
    private $dateajout;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="remise", type="string", length=255, nullable=true)
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
     * Set montans
     *
     * @param string $montans
     *
     * @return Commande
     */
    public function setMontans($montans)
    {
        $this->montans = $montans;

        return $this;
    }

    /**
     * Get montans
     *
     * @return string
     */
    public function getMontans()
    {
        return $this->montans;
    }

    /**
     * Set typelivraison
     *
     * @param string $typelivraison
     *
     * @return Commande
     */
    public function setTypelivraison($typelivraison)
    {
        $this->typelivraison = $typelivraison;

        return $this;
    }

    /**
     * Get typelivraison
     *
     * @return string
     */
    public function getTypelivraison()
    {
        return $this->typelivraison;
    }

    /**
     * Set dateajout
     *
     * @param \DateTime $dateajout
     *
     * @return Commande
     */
    public function setDateajout($dateajout)
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    /**
     * Get dateajout
     *
     * @return \DateTime
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Commande
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
     * Set client
     *
     * @param \CRM\CrmBundle\Entity\Client $client
     *
     * @return Commande
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
     * @return Commande
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
