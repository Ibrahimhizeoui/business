<?php

namespace STOCK\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lignebonreception
 *
 * @ORM\Table(name="lignebonreception")
 * @ORM\Entity(repositoryClass="STOCK\StockBundle\Repository\LignebonreceptionRepository")
 */
class Lignebonreception
{
    /**
     * @ORM\ManyToOne(targetEntity="STOCK\StockBundle\Entity\Produit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="STOCK\StockBundle\Entity\Bonreception")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $bonreception;
    
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
     * @var \DateTime
     *
     * @ORM\Column(name="datebon", type="date")
     */
    private $datebon;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=255)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="pstock", type="string", length=255, nullable=false)
     */
    private $pstock;


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
     * @return Lignebonreception
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
     * Set datebon
     *
     * @param \DateTime $datebon
     *
     * @return Lignebonreception
     */
    public function setDatebon($datebon)
    {
        $this->datebon = $datebon;

        return $this;
    }

    /**
     * Get datebon
     *
     * @return \DateTime
     */
    public function getDatebon()
    {
        return $this->datebon;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Lignebonreception
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
     * Set produit
     *
     * @param \STOCK\StockBundle\Entity\Produit $produit
     *
     * @return Lignebonreception
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
     * Set bonreception
     *
     * @param \STOCK\StockBundle\Entity\Bonreception $bonreception
     *
     * @return Lignebonreception
     */
    public function setBonreception(\STOCK\StockBundle\Entity\Bonreception $bonreception = null)
    {
        $this->bonreception = $bonreception;

        return $this;
    }

    /**
     * Get bonreception
     *
     * @return \STOCK\StockBundle\Entity\Bonreception
     */
    public function getBonreception()
    {
        return $this->bonreception;
    }

    /**
     * Set pstock
     *
     * @param string $pstock
     *
     * @return Lignebonreception
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
