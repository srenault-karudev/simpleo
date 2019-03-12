<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commercial
 *
 * @ORM\Table(name="commercial", indexes={@ORM\Index(name="id_idx", columns={"id"})})
 * @ORM\Entity
 */
class Commercial extends Person
{
    /**
     * @var string
     *
     * @ORM\Column(name="salary", type="string", length=255, nullable=true)
     */
    private $salary;


    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }



}

