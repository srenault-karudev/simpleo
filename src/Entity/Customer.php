<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity
 */
class Customer
{
    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var \Person
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @return \Person
     */
    public function getId(): \Person
    {
        return $this->id;
    }

    /**
     * @param \Person $id
     */
    public function setId(\Person $id)
    {
        $this->id = $id;
    }


    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

}

