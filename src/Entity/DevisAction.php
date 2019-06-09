<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DevisAction
 *
 * @ORM\Table(name="devisAction")
 * @ORM\Entity
 */

class DevisAction
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Collection
     *
     * @ORM\ManytoOne(targetEntity="Devis", inversedBy="DevisActions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="devis_id", referencedColumnName="id")
     * })
     */
    private $devis;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", nullable=false)
     */
    private $article;

    /**
     * @var Collection
     *
     *
     * @ORM\ManyToOne(targetEntity="Record", inversedBy="DevisActions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="record_id", referencedColumnName="id")
     * })
     */
    private $record;


    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $qtte;

    /**
     * @var float
     *
     * @ORM\Column(name="prixHT", type="float", nullable=true)
     */
    private $prixHT;

    /**
     * @var integer
     *
     * @ORM\Column(name="tauxTVA", type="integer", nullable=true)
     */
    private $tauxTVA;

    /**
     * @var integer
     *
     * @ORM\Column(name="remise", type="integer", nullable=true)
     */
    private $remise;

    /**
     * @var float
     *
     * @ORM\Column(name="montantTTC", type="float", nullable=true)
     */
    private $montantTTC;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getQtte(): ?int
    {
        return $this->qtte;
    }

    public function setQtte(?int $qtte): self
    {
        $this->qtte = $qtte;

        return $this;
    }

    public function getPrixHT(): ?float
    {
        return $this->prixHT;
    }

    public function setPrixHT(?float $prixHT): self
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    public function getTauxTVA(): ?int
    {
        return $this->tauxTVA;
    }

    public function setTauxTVA(?int $tauxTVA): self
    {
        $this->tauxTVA = $tauxTVA;

        return $this;
    }

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(?int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getMontantTTC(): ?float
    {
        return $this->montantTTC;
    }

    public function setMontantTTC(?float $montantTTC): self
    {
        $this->montantTTC = $montantTTC;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }

    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setRecord(?Record $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
    }

}
