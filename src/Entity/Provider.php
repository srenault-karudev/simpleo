<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity
 */
class Provider extends Person
{
    /**
     * @ORM\Column(type="string")
     */
    protected $personType;

    public function getPersonType(): ?string
    {
        return $this->personType;
    }

    public function setPersonType(string $type): self
    {
        $this->personType = $type;

        return $this;
    }



}

