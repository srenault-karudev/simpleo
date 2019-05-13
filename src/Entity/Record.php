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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


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


    public function __construct()
    {
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

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(Action $action): self
    {
        $this->action = $action;

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

    public function __toString(){
        return $this->id." ".$this->Nom;
    }


}

