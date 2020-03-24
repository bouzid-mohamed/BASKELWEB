<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Delegation
 *
 * @ORM\Table(name="delegation", indexes={@ORM\Index(name="fk_deleg", columns={"id_gouv"})})
 * @ORM\Entity
 */
class Delegation
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_deleg", type="string", length=20, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nomDeleg;

    /**
     * @var \Gouvernorat
     *
     * @ORM\ManyToOne(targetEntity="Gouvernorat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_gouv", referencedColumnName="id_gouv")
     * })
     */
    private $idGouv;

    /**
     * @return string
     */
    public function getNomDeleg()
    {
        return $this->nomDeleg;
    }

    /**
     * @param string $nomDeleg
     */
    public function setNomDeleg($nomDeleg)
    {
        $this->nomDeleg = $nomDeleg;
    }

    /**
     * @return \Gouvernorat
     */
    public function getIdGouv()
    {
        return $this->idGouv;
    }

    /**
     * @param \Gouvernorat $idGouv
     */
    public function setIdGouv($idGouv)
    {
        $this->idGouv = $idGouv;
    }



}

