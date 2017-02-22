<?php

namespace STOCK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bonreception
 *
 * @ORM\Table(name="bonreception")
 * @ORM\Entity(repositoryClass="STOCK\StockBundle\Repository\BonreceptionRepository")
 */
class Bonreception
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
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateajout", type="date", nullable=true)
     */
    private $dateajout;

    /**
     * @var string
     *
     * @ORM\Column(name="typelivraison", type="string", length=255, nullable=true)
     */
    private $typelivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="montans", type="string", length=255, nullable=true)
     */
    private $montans;

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
     * Set status
     *
     * @param string $status
     *
     * @return Bonreception
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
     * @return Bonreception
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
     * Set dateajout
     *
     * @param \DateTime $dateajout
     *
     * @return Bonreception
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
     * Set typelivraison
     *
     * @param string $typelivraison
     *
     * @return Bonreception
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
     * Set montans
     *
     * @param string $montans
     *
     * @return Bonreception
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
     * Set fournisseur
     *
     * @param \STOCK\StockBundle\Entity\Fournisseur $fournisseur
     *
     * @return Bonreception
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
     * Set pstock
     *
     * @param string $pstock
     *
     * @return Bonreception
     */
    public function setPstock($pstock)
    {
        $this->pstock = $pstock;

        return $this;
    }

    /**
     * Get pstock
     *
     * @return string
     */
    public function getPstock()
    {
        return $this->pstock;
    }

    /**
     * Set remise
     *
     * @param string $remise
     *
     * @return Bonreception
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
