<?php

namespace CRM\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compagne
 *
 * @ORM\Table(name="compagne")
 * @ORM\Entity(repositoryClass="CRM\CrmBundle\Repository\CompagneRepository")
 */
class Compagne
{
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
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="moyenne", type="string", length=255)
     */
    private $moyenne;

    /**
     * @var string
     *
     * @ORM\Column(name="budget", type="string", length=255, nullable=true)
     */
    private $budget;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefermeture", type="date")
     */
    private $datefermeture;


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
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Compagne
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Compagne
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
     * Set moyenne
     *
     * @param string $moyenne
     *
     * @return Compagne
     */
    public function setMoyenne($moyenne)
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    /**
     * Get moyenne
     *
     * @return string
     */
    public function getMoyenne()
    {
        return $this->moyenne;
    }

    /**
     * Set budget
     *
     * @param string $budget
     *
     * @return Compagne
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set datefermeture
     *
     * @param \DateTime $datefermeture
     *
     * @return Compagne
     */
    public function setDatefermeture($datefermeture)
    {
        $this->datefermeture = $datefermeture;

        return $this;
    }

    /**
     * Get datefermeture
     *
     * @return \DateTime
     */
    public function getDatefermeture()
    {
        return $this->datefermeture;
    }
}

