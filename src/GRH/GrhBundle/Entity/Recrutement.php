<?php

namespace GRH\GrhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recrutement
 *
 * @ORM\Table(name="recrutement")
 * @ORM\Entity(repositoryClass="GRH\GrhBundle\Repository\RecrutementRepository")
 */
class Recrutement
{
    /**
     * @ORM\ManyToOne(targetEntity="GRH\GrhBundle\Entity\Departement")
     * @ORM\JoinColumn(nullable=true)
     */
    private $departement;
    
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
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_employes", type="integer", nullable=true)
     */
    private $nbEmployes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="date", nullable=true)
     */
    private $dateAjout;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255, nullable=true)
     */
    private $intitule;


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
     * Set type
     *
     * @param string $type
     *
     * @return Recrutement
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
     * Set description
     *
     * @param string $description
     *
     * @return Recrutement
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
     * Set nbEmployes
     *
     * @param integer $nbEmployes
     *
     * @return Recrutement
     */
    public function setNbEmployes($nbEmployes)
    {
        $this->nbEmployes = $nbEmployes;

        return $this;
    }

    /**
     * Get nbEmployes
     *
     * @return int
     */
    public function getNbEmployes()
    {
        return $this->nbEmployes;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Recrutement
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Recrutement
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
     * Set departement
     *
     * @param \GRH\GrhBundle\Entity\Departement $departement
     *
     * @return Recrutement
     */
    public function setDepartement(\GRH\GrhBundle\Entity\Departement $departement = null)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \GRH\GrhBundle\Entity\Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Recrutement
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }
}
