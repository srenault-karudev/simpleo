<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider", indexes={@ORM\Index(name="constraint_provider_person", columns={"id"})})
 * @ORM\Entity
 */
class Provider
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cle", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cle;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255, nullable=false)
     */
    private $categoryname;

    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getCle(): ?int
    {
        return $this->cle;
    }

    public function getCategoryname(): ?string
    {
        return $this->categoryname;
    }

    public function setCategoryname(string $categoryname): self
    {
        $this->categoryname = $categoryname;

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

