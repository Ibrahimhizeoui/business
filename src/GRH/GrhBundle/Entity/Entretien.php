<?php

namespace GRH\GrhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entretien
 *
 * @ORM\Table(name="entretien" )
 * @ORM\Entity(repositoryClass="GRH\GrhBundle\Repository\EntretienRepository")
 */
class Entretien
{
    /**
     * @ORM\OneToOne(targetEntity="GRH\GrhBundle\Entity\Condidat")
     * @ORM\JoinColumn(nullable=true,onDelete="CASCADE")
     */
    private $condidat;
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255,nullable=true)
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
     * Set description
     *
     * @param string $description
     *
     * @return Entretien
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
     * @return Entretien
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
     * Set condidat
     *
     * @param \GRH\GrhBundle\Entity\Condidat $condidat
     *
     * @return Entretien
     */
    public function setCondidat(\GRH\GrhBundle\Entity\Condidat $condidat = null)
    {
        $this->condidat = $condidat;

        return $this;
    }

    /**
     * Get condidat
     *
     * @return \GRH\GrhBundle\Entity\Condidat
     */
    public function getCondidat()
    {
        return $this->condidat;
    }
}
