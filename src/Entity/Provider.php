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
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255, nullable=false)
     */
    private $categoryname;



    public function getCategoryname(): ?string
    {
        return $this->categoryname;
    }

    public function setCategoryname(string $categoryname): self
    {
        $this->categoryname = $categoryname;

        return $this;
    }



}

