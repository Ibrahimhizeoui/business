<?php

namespace GRH\GrhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employe
 *
 * @ORM\Table(name="employe")
 * @ORM\Entity(repositoryClass="GRH\GrhBundle\Repository\EmployeRepository")
 */
class Employe
{
    /**
     * @ORM\ManyToOne(targetEntity="GRH\GrhBundle\Entity\Departement")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $departement;
    

    /**
     * @ORM\ManyToOne(targetEntity="GRH\GrhBundle\Entity\Post")
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $post;
    
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="datenaissance", type="date",nullable=true)
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255, nullable=true)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="etatcivil", type="string", length=255, nullable=true)
     */
    private $etatcivil;

    /**
     * @var int
     *
     * @ORM\Column(name="soldeconges",type="integer", nullable=true)
     */
    private $soldeconges;

    /**
     * @var string
     *
     * @ORM\Column(name="salaire", type="string", length=255, nullable=true)
     */
    private $salaire;
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;


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
     * @return Employe
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
     * @return Employe
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
     * Set email
     *
     * @param string $email
     *
     * @return Employe
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Employe
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Employe
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

    /**
     * Set datenaissance
     *
     * @param string $datenaissance
     *
     * @return Employe
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return string
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Employe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Employe
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set etatcivil
     *
     * @param string $etatcivil
     *
     * @return Employe
     */
    public function setEtatcivil($etatcivil)
    {
        $this->etatcivil = $etatcivil;

        return $this;
    }

    /**
     * Get etatcivil
     *
     * @return string
     */
    public function getEtatcivil()
    {
        return $this->etatcivil;
    }

    /**
     * Set post
     *
     * @param \GRH\GrhBundle\Entity\Post $post
     *
     * @return Employe
     */
    public function setPost(\GRH\GrhBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \GRH\GrhBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set departement
     *
     * @param \GRH\GrhBundle\Entity\Departement $departement
     *
     * @return Employe
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
     * Set soldeconges
     *
     * @param integer $soldeconges
     *
     * @return Employe
     */
    public function setSoldeconges($soldeconges)
    {
        $this->soldeconges = $soldeconges;

        return $this;
    }

    /**
     * Get soldeconges
     *
     * @return integer
     */
    public function getSoldeconges()
    {
        return $this->soldeconges;
    }

   

    /**
     * Set salaire
     *
     * @param string $salaire
     *
     * @return Employe
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return string
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Employe
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
