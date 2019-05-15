<?php

namespace App\Entity;


class PropertySearch{
    /**
     * @var string|null
     */

    private $firstName;

    /**
     * @var string|null
     */

    private $lastName;


    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstname
     * @return PropertySearch
     */
    public function setFirstName(string $firstName): PropertySearch
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastname
     * @return PropertySearch
     */
    public function setLastName(string $lastName): PropertySearch
    {
        $this->lastName = $lastName;
        return $this;
    }

}