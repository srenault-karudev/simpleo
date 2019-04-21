<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\ManytoOne(targetEntity="User", inversedBy="invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * @var Collection
     *
     * @ORM\OnetoMany(targetEntity="Action", mappedBy="invoice")
     */
    private $actions;


    /**
     * @var integer
     *
     * @ORM\Column(name="interlocutor", type="integer", nullable=false)
     */
    private $interlocutor_id;

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


}

