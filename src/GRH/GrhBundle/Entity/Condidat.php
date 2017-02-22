<?php

namespace GRH\GrhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Condidat
 *
 * @ORM\Table(name="condidat")
 * @ORM\Entity(repositoryClass="GRH\GrhBundle\Repository\CondidatRepository")
 */
class Condidat
{
    /**
     * @ORM\ManyToOne(targetEntity="GRH\GrhBundle\Entity\Recrutement")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recrutement;
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenaiss", type="date", nullable=true)
     */
    private $datenaiss;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateentretien", type="date", nullable=true)
     */
    private $dateentretien;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="text", nullable=true)
     */
    private $remarque;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Condidat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Condidat
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set datenaiss
     *
     * @param \DateTime $datenaiss
     *
     * @return Condidat
     */
    public function setDatenaiss($datenaiss)
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    /**
     * Get datenaiss
     *
     * @return \DateTime
     */
    public function getDatenaiss()
    {
        return $this->datenaiss;
    }

    /**
     * Set dateentretien
     *
     * @param \DateTime $dateentretien
     *
     * @return Condidat
     */
    public function setDateentretien($dateentretien)
    {
        $this->dateentretien = $dateentretien;

        return $this;
    }

    /**
     * Get dateentretien
     *
     * @return \DateTime
     */
    public function getDateentretien()
    {
        return $this->dateentretien;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return Condidat
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set remarque
     *
     * @param string $remarque
     *
     * @return Condidat
     */
    public function setRemarque($remarque)
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * Get remarque
     *
     * @return string
     */
    public function getRemarque()
    {
        return $this->remarque;
    }

    /**
     * Set recrutement
     *
     * @param \GRH\GrhBundle\Entity\Recrutement $recrutement
     *
     * @return Condidat
     */
    public function setRecrutement(\GRH\GrhBundle\Entity\Recrutement $recrutement = null)
    {
        $this->recrutement = $recrutement;

        return $this;
    }

    /**
     * Get recrutement
     *
     * @return \GRH\GrhBundle\Entity\Recrutement
     */
    public function getRecrutement()
    {
        return $this->recrutement;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Condidat
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }
}
