<?php
namespace  AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonces
 *
 * @ORM\Table(name="annonces", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Annonces
{
    /**
     * @ORM\ManyToOne(targetEntity="Annonce\Entity\User", inversedBy="Annonces")
     */
    /**
     * @var integer
     *
     * @ORM\Column(name="ann_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $annId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_tel", type="integer", nullable=false)
     */
    private $numTel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="gouvernorat", type="string", length=20, nullable=false)
     */
    private $gouvernorat;

    /**
     * @var string
     *
     * @ORM\Column(name="delegation", type="string", length=60, nullable=false)
     */
    private $delegation;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=50, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=200, nullable=false)
     */
    private $photo;

    /**
     * @var integer
     *
     * @ORM\Column(name="signals", type="integer", nullable=false)
     */
    private $signals;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_heure", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixHeure;

    /**
     * @var integer
     *
     * @ORM\Column(name="dispo", type="integer", nullable=true)
     */
    private $dispo;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrdispo", type="integer", nullable=true)
     */
    private $nbrdispo;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_jour", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixJour;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return int
     */
    public function getAnnId()
    {
        return $this->annId;
    }

    /**
     * @param int $annId
     */
    public function setAnnId($annId)
    {
        $this->annId = $annId;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @param int $numTel
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }

    /**
     * @param string $gouvernorat
     */
    public function setGouvernorat($gouvernorat)
    {
        $this->gouvernorat = $gouvernorat;
    }

    /**
     * @return string
     */
    public function getDelegation()
    {
        return $this->delegation;
    }

    /**
     * @param string $delegation
     */
    public function setDelegation($delegation)
    {
        $this->delegation = $delegation;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return int
     */
    public function getSignals()
    {
        return $this->signals;
    }

    /**
     * @param int $signals
     */
    public function setSignals($signals)
    {
        $this->signals = $signals;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return float
     */
    public function getPrixHeure()
    {
        return $this->prixHeure;
    }

    /**
     * @param float $prixHeure
     */
    public function setPrixHeure($prixHeure)
    {
        $this->prixHeure = $prixHeure;
    }

    /**
     * @return int
     */
    public function getDispo()
    {
        return $this->dispo;
    }

    /**
     * @param int $dispo
     */
    public function setDispo($dispo)
    {
        $this->dispo = $dispo;
    }

    /**
     * @return int
     */
    public function getNbrdispo()
    {
        return $this->nbrdispo;
    }

    /**
     * @param int $nbrdispo
     */
    public function setNbrdispo($nbrdispo)
    {
        $this->nbrdispo = $nbrdispo;
    }

    /**
     * @return float
     */
    public function getPrixJour()
    {
        return $this->prixJour;
    }

    /**
     * @param float $prixJour
     */
    public function setPrixJour($prixJour)
    {
        $this->prixJour = $prixJour;
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */



}

