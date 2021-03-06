<?php

namespace GRH\GrhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salaire
 *
 * @ORM\Table(name="salaire")
 * @ORM\Entity(repositoryClass="GRH\GrhBundle\Repository\SalaireRepository")
 */
class Salaire
{
    /**
     * @ORM\ManyToOne(targetEntity="GRH\GrhBundle\Entity\Employe")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $employe;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nbjours", type="integer", nullable=true)
     */
    private $nbjours;

    /**
     * @var string
     *
     * @ORM\Column(name="montans", type="string", length=255, nullable=true)
     */
    private $montans;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepay", type="date", nullable=true)
     */
    private $datepay;


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
     * Set nbjours
     *
     * @param integer $nbjours
     *
     * @return Salaire
     */
    public function setNbjours($nbjours)
    {
        $this->nbjours = $nbjours;

        return $this;
    }

    /**
     * Get nbjours
     *
     * @return int
     */
    public function getNbjours()
    {
        return $this->nbjours;
    }

    /**
     * Set montans
     *
     * @param string $montans
     *
     * @return Salaire
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
     * Set datepay
     *
     * @param \DateTime $datepay
     *
     * @return Salaire
     */
    public function setDatepay($datepay)
    {
        $this->datepay = $datepay;

        return $this;
    }

    /**
     * Get datepay
     *
     * @return \DateTime
     */
    public function getDatepay()
    {
        return $this->datepay;
    }

    /**
     * Set employe
     *
     * @param \GRH\GrhBundle\Entity\Employe $employe
     *
     * @return Salaire
     */
    public function setEmploye(\GRH\GrhBundle\Entity\Employe $employe = null)
    {
        $this->employe = $employe;

        return $this;
    }

    /**
     * Get employe
     *
     * @return \GRH\GrhBundle\Entity\Employe
     */
    public function getEmploye()
    {
        return $this->employe;
    }
}
