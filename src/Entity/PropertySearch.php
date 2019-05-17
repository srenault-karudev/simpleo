<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;



class PropertySearch{

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

    }
    /**
     * @var string|null
     */

    private $value;




    /**
     * @return null|string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param null|string $value
     * @return PropertySearch
     */
    public function setValue(string $value): PropertySearch
    {
        $this->value = $value;
        return $this;
    }





}