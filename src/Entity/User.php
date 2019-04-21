<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Person", mappedBy="user")
     *
     */
    private $persons;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Company", mappedBy="user")
     *
     */
    private $company;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trial_period", type="boolean")
     */
    private $trialPeriod = false ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_trial_period", type="datetime",nullable=false)
     */
    private $dateOfTrialPeriod;



    public function __construct()
    {
        parent::__construct();
        $this->persons = new ArrayCollection();
        $this->dateOfTrialPeriod = new \DateTime();

    }




    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $company === null ? null : $this;
        if ($newUser !== $company->getUser()) {
            $company->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPersons(): Collection
    {
        return $this->persons;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->persons->contains($person)) {
            $this->persons[] = $person;
            $person->setUser($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->persons->contains($person)) {
            $this->persons->removeElement($person);
            // set the owning side to null (unless already changed)
            if ($person->getUser() === $this) {
                $person->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfTrialPeriod(): \DateTime
    {
        return $this->dateOfTrialPeriod;
    }

    /**
     * @param \DateTime $dateOfTrialPeriod
     */
    public function setDateOfTrialPeriod(\DateTime $dateOfTrialPeriod)
    {
        $this->dateOfTrialPeriod = $dateOfTrialPeriod;
    }

    /**
     * @return bool
     */
    public function isTrialPeriod(): bool
    {
        return $this->trialPeriod;
    }

    /**
     * @param bool $trialPeriod
     */
    public function setTrialPeriod(bool $trialPeriod)
    {
        $this->trialPeriod = $trialPeriod;
    }


}

