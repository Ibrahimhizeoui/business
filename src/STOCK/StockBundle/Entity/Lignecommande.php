<?php

namespace STOCK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lignecommande
 *
 * @ORM\Table(name="lignecommande")
 * @ORM\Entity(repositoryClass="STOCK\StockBundle\Repository\LignecommandeRepository")
 */
class Lignecommande
{
    /**
     * @ORM\ManyToOne(targetEntity="STOCK\StockBundle\Entity\Produit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="STOCK\StockBundle\Entity\Commande")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $commande;
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
     * @ORM\Column(name="quantite", type="string", length=255)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=255)
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecom", type="date")
     */
    private $datecom;

    /**
     * @var string
     *
     * @ORM\Column(name="pstock", type="string", length=255)
     */
    private $pstock;

    public function __construct()
    {
        $this->datecom = new \DateTime();
    }




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
     * Set quantite
     *
     * @param string $quantite
     *
     * @return Lignecommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return string
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set datecom
     *
     * @param \DateTime $datecom
     *
     * @return Lignecommande
     */
    public function setDatecom($datecom)
    {
        $this->datecom = $datecom;

        return $this;
    }

    /**
     * Get datecom
     *
     * @return \DateTime
     */
    public function getDatecom()
    {
        return $this->datecom;
    }

    /**
     * Set produit
     *
     * @param \STOCK\StockBundle\Entity\Produit $produit
     *
     * @return Lignecommande
     */
    public function setProduit(\STOCK\StockBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \STOCK\StockBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set commande
     *
     * @param \STOCK\StockBundle\Entity\Commande $commande
     *
     * @return Lignecommande
     */
    public function setCommande(\STOCK\StockBundle\Entity\Commande $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \STOCK\StockBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Lignecommande
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
     * Set pstock
     *
     * @param string $pstock
     *
     * @return Lignecommande
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
}
