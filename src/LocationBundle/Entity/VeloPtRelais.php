<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VeloPtRelais
 *
 * @ORM\Table(name="velo_pt_relais", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id_velo", columns={"id_velo"})})
 * @ORM\Entity
 */
class VeloPtRelais
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_location", type="datetime", nullable=false)
     */
    private $dateLocation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_f", type="datetime", nullable=false)
     */
    private $dateF;

    /**
     * @var float
     *
     * @ORM\Column(name="prixlocation", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixlocation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var \Velo
     *
     * @ORM\ManyToOne(targetEntity="Velo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_velo", referencedColumnName="id")
     * })
     */
    private $idVelo;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateLocation()
    {
        return $this->dateLocation;
    }

    /**
     * @param \DateTime $dateLocation
     */
    public function setDateLocation($dateLocation)
    {
        $this->dateLocation = $dateLocation;
    }

    /**
     * @return \DateTime
     */
    public function getDateF()
    {
        return $this->dateF;
    }

    /**
     * @param \DateTime $dateF
     */
    public function setDateF($dateF)
    {
        $this->dateF = $dateF;
    }

    /**
     * @return float
     */
    public function getPrixlocation()
    {
        return $this->prixlocation;
    }

    /**
     * @param float $prixlocation
     */
    public function setPrixlocation($prixlocation)
    {
        $this->prixlocation = $prixlocation;
    }

    /**
     * @return \User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \Velo
     */
    public function getIdVelo()
    {
        return $this->idVelo;
    }

    /**
     * @param \Velo $idVelo
     */
    public function setIdVelo($idVelo)
    {
        $this->idVelo = $idVelo;
    }


}

