<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * Provider
 *
 * @ORM\Table(name="record")
 * @ORM\Entity(repositoryClass="App\Repository\RecordRepository")
 */
class Record
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="num", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $Num;

    /**
     * @var String
     *
     * @ORM\Column(name="Format", type="string", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $Format;

    /**
     * @var String
     *
     * @ORM\Column(name="Nom", type="string", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $Nom;

    /**
     * @var Collection
     *
     * @ORM\OnetoMany(targetEntity="Action", mappedBy="record")
     */
    private $actions;

    /**
     * @var Collection
     *
     * @ORM\OnetoMany(targetEntity="Invoice", mappedBy="record")
     */
    private $invoices;


    public function __construct()
    {
       
        $this->invoices = new ArrayCollection();
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormat(): ?int
    {
        return $this->Format;
    }

    public function setFormat(int $Format): self
    {
        $this->Format = $Format;

        return $this;
    }

    public function getNom(): ?int
    {
        return $this->Nom;
    }

    public function setNom(int $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function __toString(){
        return $this->Num." - ".$this->Nom;
    }

    public function getNum(): ?int
    {
        return $this->Num;
    }

    public function setNum(int $Num): self
    {
        $this->Num = $Num;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setRecord($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getRecord() === $this) {
                $invoice->setRecord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setRecord($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getRecord() === $this) {
                $action->setRecord(null);
            }
        }

        return $this;
    }



}