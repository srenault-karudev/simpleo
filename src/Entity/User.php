<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="user")
     */
    private $person;

    public function __construct()
    {
        parent::__construct();
        $this->person = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->person->contains($person)) {
            $this->person[] = $person;
            $person->addUser($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->person->contains($person)) {
            $this->person->removeElement($person);
            $person->removeUser($this);
        }

        return $this;
    }




}

