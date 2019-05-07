<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Finder\Comparator\NumberComparator;

/**
 * Action
 *
 * @ORM\Table(name="Action")
 * @ORM\Entity
 */
class Action
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
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="actions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     * })
     */
    private $invoice;

    /**
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Record", mappedBy="action")
     *
     */
    private $record;

    /**
     * @var float
     *
     * @ORM\Column(name="tva", type="float", nullable=false)
     */
    private $tva;

    /**
     * @var float
     *
     * @ORM\Column(name="tva_amount", type="float", nullable=false)
     */
    private $tva_amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="unit_amount", type="float", nullable=false)
     */
    private $unit_amount;

    public function __construct()
    {
        $this->invoice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

  

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTvaAmount(): ?float
    {
        return $this->tva_amount;
    }

    public function setTvaAmount(float $tva_amount): self
    {
        $this->tva_amount = $tva_amount;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitAmount(): ?float
    {
        return $this->unit_amount;
    }

    public function setUnitAmount(float $unit_amount): self
    {
        $this->unit_amount = $unit_amount;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoice(): Collection
    {
        return $this->invoice;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoice->contains($invoice)) {
            $this->invoice[] = $invoice;
            $invoice->setActions($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoice->contains($invoice)) {
            $this->invoice->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getActions() === $this) {
                $invoice->setActions(null);
            }
        }

        return $this;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setRecord(?Record $record): self
    {
        $this->record = $record;

        // set (or unset) the owning side of the relation if necessary
        $newAction = $record === null ? null : $this;
        if ($newAction !== $record->getAction()) {
            $record->setAction($newAction);
        }

        return $this;
    }


}

