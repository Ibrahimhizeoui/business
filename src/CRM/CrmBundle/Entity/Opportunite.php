<?php

namespace CRM\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opportunite
 *
 * @ORM\Table(name="opportunite")
 * @ORM\Entity(repositoryClass="CRM\CrmBundle\Repository\OpportuniteRepository")
 */
class Opportunite
{
    /**
     * @ORM\ManyToOne(targetEntity="CRM\CrmBundle\Entity\Client")
     * @ORM\JoinColumn(nullable=true,onDelete="cascade")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="CRM\CrmBundle\Entity\Compagne")
     * @ORM\JoinColumn(nullable=true,onDelete="cascade")
     */
    private $Compagne;

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
     * @ORM\Column(name="activite", type="string", length=255)
     */
    private $activite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefermeture", type="date")
     */
    private $datefermeture;

    /**
     * @var string
     *
     * @ORM\Column(name="revenue", type="string", length=255)
     */
    private $revenue;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="fermer", type="string", length=255)
     */
    private $fermer;

    /**
     * @var string
     *
     * @ORM\Column(name="gagnier", type="string", length=255,nullable=true)
     */
    private $gagnier;


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
     * @return Opportunite
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
     * Set activite
     *
     * @param string $activite
     *
     * @return Opportunite
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get activite
     *
     * @return string
     */
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * Set datefermeture
     *
     * @param \DateTime $datefermeture
     *
     * @return Opportunite
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

    /**
     * Set revenue
     *
     * @param string $revenue
     *
     * @return Opportunite
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;

        return $this;
    }

    /**
     * Get revenue
     *
     * @return string
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * Set client
     *
     * @param \CRM\CrmBundle\Entity\Client $client
     *
     * @return Opportunite
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
     * Set type
     *
     * @param string $type
     *
     * @return Opportunite
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
     * Set compagne
     *
     * @param \CRM\CrmBundle\Entity\Compagne $compagne
     *
     * @return Opportunite
     */
    public function setCompagne(\CRM\CrmBundle\Entity\Compagne $compagne = null)
    {
        $this->Compagne = $compagne;

        return $this;
    }

    /**
     * Get compagne
     *
     * @return \CRM\CrmBundle\Entity\Compagne
     */
    public function getCompagne()
    {
        return $this->Compagne;
    }

    /**
     * Set fermer
     *
     * @param string $fermer
     *
     * @return Opportunite
     */
    public function setFermer($fermer)
    {
        $this->fermer = $fermer;

        return $this;
    }

    /**
     * Get fermer
     *
     * @return string
     */
    public function getFermer()
    {
        return $this->fermer;
    }

    /**
     * Set gagnier
     *
     * @param string $gagnier
     *
     * @return Opportunite
     */
    public function setGagnier($gagnier)
    {
        $this->gagnier = $gagnier;

        return $this;
    }

    /**
     * Get gagnier
     *
     * @return string
     */
    public function getGagnier()
    {
        return $this->gagnier;
    }
}
