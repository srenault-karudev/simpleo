<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints\Date;



/**
 * Invoice
 *
 * @ORM\Table(name="Invoice")
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
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
     * @var Date
     *
     * @ORM\Column(name="invoice_date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="invoice_type", type="boolean")
     */
    private $invoice_type;


    /**
     * @var float
     *
     * @ORM\Column(name="ht_price", type="float", nullable=false)
     */
    private $price_Ht;

    /**
     * @var float
     *
     * @ORM\Column(name="tt_price", type="float", nullable=false)
     */
    private $price_tt;


    /**
     * @var Collection
     *
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Action", mappedBy="invoice")
     */
    private $actions;


    /**
     * @var Collection
     *
     *
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * })
     */
    private $client;


    /**
     * @var Collection
     *
     *
     * @ORM\ManyToOne(targetEntity="Record", inversedBy="invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="paiement_id", referencedColumnName="id")
     * })
     */
    private $paiement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="state_of_paiement", type="boolean")
     */
    private $stateOfPaiement = false;


    /**
     * @var Date
     *
     * @ORM\Column(name="paiment_date", type="date", nullable=false)
     */
    private $paiment_date;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getInvoiceType(): ?bool
    {
        return $this->invoice_type;
    }

    public function setInvoiceType(bool $invoice_type): self
    {
        $this->invoice_type = $invoice_type;

        return $this;
    }

    public function getPriceHt()
    {
        return $this->price_Ht;
    }

    public function setPriceHt($price_Ht): self
    {
        $this->price_Ht = $price_Ht;

        return $this;
    }

    public function getPriceTt()
    {
        return $this->price_tt;
    }

    public function setPriceTt($price_tt): self
    {
        $this->price_tt = $price_tt;

        return $this;
    }

    public function getInterlocutorId(): ?int
    {
        return $this->interlocutor_id;
    }

    public function setInterlocutorId(int $interlocutor_id): self
    {
        $this->interlocutor_id = $interlocutor_id;

        return $this;
    }



    /**
     * @return Collection|action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setInvoice($this);
        }

        return $this;
    }

    public function removeAction(action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getInvoice() === $this) {
                $action->setInvoice(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getPaiement(): ?Record
    {
        return $this->paiement;
    }

    public function setPaiement(?Record $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function calcultHtPrice($datas){
        $htPrice = 0;
        //return $qtte * $unitAmount;

        foreach ($datas as $data){
            $qtte = $data[2];
            $unitAmount =  $data[4];

            $htPrice += $qtte *$unitAmount;

        }
        return $htPrice;
    }

    public function calculTtcPrice($datas){
        //return $htPrice + $tvaAmount;

        $ttcPrie = 0;
        foreach ($datas as $data){
            $qtte = $data[2];
            $unitAmount =  $data[4];
            $ttcPrie += $qtte *$unitAmount+$data[3];
        }
        return $ttcPrie;
    }

    /**
     * @return bool
     */
    public function isStateOfPaiement(): bool
    {
        return $this->stateOfPaiement;
    }

    /**
     * @param bool $stateOfPaiement
     */
    public function setStateOfPaiement(bool $stateOfPaiement)
    {
        $this->stateOfPaiement = $stateOfPaiement;
    }

    public function getStateOfPaiement(): ?bool
    {
        return $this->stateOfPaiement;
    }

    public function getPaimentDate(): ?\DateTimeInterface
    {
        return $this->paiment_date;
    }

    public function setPaimentDate(\DateTimeInterface $paiment_date): self
    {
        $this->paiment_date = $paiment_date;

        return $this;
    }


}

