<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gouvernorat
 *
 * @ORM\Table(name="gouvernorat")
 * @ORM\Entity
 */
class Gouvernorat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_gouv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGouv;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_gouv", type="string", length=20, nullable=false)
     */
    private $nomGouv;

    /**
     * @return int
     */
    public function getIdGouv()
    {
        return $this->idGouv;
    }

    /**
     * @param int $idGouv
     */
    public function setIdGouv($idGouv)
    {
        $this->idGouv = $idGouv;
    }

    /**
     * @return string
     */
    public function getNomGouv()
    {
        return $this->nomGouv;
    }

    /**
     * @param string $nomGouv
     */
    public function setNomGouv($nomGouv)
    {
        $this->nomGouv = $nomGouv;
    }



}

