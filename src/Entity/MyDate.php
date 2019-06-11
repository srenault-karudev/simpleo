<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Customer
 *
 *
 * @ORM\Table(name="customer")

 */
class MyDate extends \DateTime
{


    /**
     * Return Date in ISO8601 format
     *
     * @return String
     */
    public function __toString() {
        return $this->format('Y-m-d H:i');
    }

    /**
     * Return Age in Years
     *
     * @param Datetime|String $now
     * @return Integer
     */
    public function getMonth($now = 'NOW') {
        return $this->format('n');
    }

    public function getLastMonth($now = 'NOW') {
        if($this->format('n') == 1){
            return 12;
        }else{
            return $this->format('n')-1;
        }
    }
}

