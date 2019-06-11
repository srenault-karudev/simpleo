<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Devis
 *
 * @ORM\Table(name="devis")
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
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
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="devis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=45, nullable=true)
     */
    private $reference;


    /**
     * @var Date
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;



    /**
     * @var Date
     *
     * @ORM\Column(name="date_expiration", type="date", nullable=false)
     */
    private $dateExpiration;


    /**
     * @var Collection
     *
     *
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="deviss")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=40, nullable=true)
     */
    private $telephone;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=40, nullable=true)
     */
    private $etat;

    /**
     * @var float
     *
     * @ORM\Column(name="montantHT", type="float", nullable=true)
     */
    private $montantHT;

    /**
     * @var float
     *
     * @ORM\Column(name="montantTVA", type="float", nullable=true)
     */
    private $montantTVA;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", nullable=true)
     */
    private $montant;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="DevisAction", mappedBy="devis",cascade={"persist", "remove"}, orphanRemoval=true))
     */
    private $devisActions;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actions = new ArrayCollection();
        $this->devisActions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->addDevis($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            $user->removeDevis($this);
        }

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    

    /**
     * @return string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat(string $etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return float
     */
    public function getMontant(): ?float
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant(float $montant)
    {
        $this->montant = $montant;
    }

    public function getClient(): ?Person
    {
        return $this->client;
    }

    public function setClient(?Person $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function calculMontantTVA($datas){

        $montantTVA = 0;
        foreach ($datas as $data){
            $montantTVA += ($data[2]*$data[3])*($data[4]/100);
        }
        return $montantTVA;
    }


    public function calculTotalHT($datas){
        //return $htPrice + $tvaAmount;

        $totalHT = 0;
        foreach ($datas as $data){
            $totalHT += $data[3];
        }
        return $totalHT;
    }

    public function additionTTCs($datas){

        $TTC = 0;
        foreach ($datas as $data){
            $TTC += $data[6];
        }
        return $TTC;
    }

    /**
     * @return Collection|DevisAction[]
     */
    public function getDevisActions(): Collection
    {
        return $this->devisActions;
    }

    public function addDevisAction(DevisAction $devisAction): self
    {
        if (!$this->devisActions->contains($devisAction)) {
            $this->devisActions[] = $devisAction;
            $devisAction->setDevis($this);
        }

        return $this;
    }


    public function removeDevisAction(DevisAction $devisAction): self
    {
        if ($this->devisActions->contains($devisAction)) {
            $this->devisActions->removeElement($devisAction);
            // set the owning side to null (unless already changed)
            if ($devisAction->getDevis() === $this) {
                $devisAction->setDevis(null);
            }
        }

        return $this;
    }

    public function getMontantHT(): ?float
    {
        return $this->montantHT;
    }

    public function setMontantHT(?float $montantHT): self
    {
        $this->montantHT = $montantHT;

        return $this;
    }

    public function getMontantTVA(): ?float
    {
        return $this->montantTVA;
    }

    public function setMontantTVA(?float $montantTVA): self
    {
        $this->montantTVA = $montantTVA;

        return $this;
    }


}

