<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commercial
 *
 * @ORM\Table(name="commercial", indexes={@ORM\Index(name="id_idx", columns={"id"})})
 * @ORM\Entity
 */
class Commercial
{
    /**
     * @var string
     *
     * @ORM\Column(name="cle", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cle;

    /**
     * @var string
     *
     * @ORM\Column(name="salary", type="string", length=255, nullable=true)
     */
    private $salary;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getId(): ?Person
    {
        return $this->id;
    }

    public function setId(?Person $id): self
    {
        $this->id = $id;

        return $this;
    }


}

