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
    const SIMPLE_ID = 'simple';
    const COMPLETE_ID = 'complete';
    const TRIAL_PEREIOD = 'essai';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $stripeCustomerId;



    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="user")
     */
    private $invoices;


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
     * @ORM\Column(name="state", type="boolean")
     */
    private $state = true ;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_trial_period", type="datetime",nullable=false)
     */
    private $dateOfTrialPeriod;

    /**
     * @var string
     *
     * @ORM\Column(name="formula", type="string", length=255, nullable=true)
     */
    private $formula;



    public function __construct()
    {
        parent::__construct();
        $this->persons = new ArrayCollection();

        $this->invoices = new ArrayCollection();

        $this->dateOfTrialPeriod = new \DateTime();

    }



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setUser($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getUser() === $this) {
                $invoice->setUser(null);
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
     * @return string
     */
    public function getFormula(): ?string
    {
        return $this->formula;
    }

    /**
     * @param string $formula
     */
    public function setFormula(?string $formula)
    {
        $this->formula = $formula;
    }
    /**
     * @return bool
     */
    public function isState(): bool
    {
        return $this->state;
    }

    /**
     * @param bool $state
     */
    public function setState(bool $state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getStripeCustomerId()
    {
        return $this->stripeCustomerId;
    }

    /**
     * @param mixed $stripeCustomerId
     */
    public function setStripeCustomerId($stripeCustomerId)
    {
        $this->stripeCustomerId = $stripeCustomerId;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }


}

