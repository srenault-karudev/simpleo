<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Person
 *
 * @ORM\Table(name="person")
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
*  @ORM\InheritanceType("SINGLE_TABLE")
*  @ORM\DiscriminatorColumn(name="type", type="string")
*  @ORM\DiscriminatorMap( {
*      "customer" = "Customer",
*  } )
 */


abstract class Person
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
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="companyName", type="string", length=255, nullable=true)
     */
    protected $companyname;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    protected $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="postcode", type="integer", length=255, nullable=true)
     */
    protected $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(name="mobilePhone", type="string", length=10, nullable=true)
     */
    protected $mobilephone;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Team", mappedBy="person")
     */
    private $team;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected $email;


    /**
     * @var integer
     *
     * @ORM\Column(name="siren", type="integer", length=9, nullable=true)
     */
    protected $siren;


    /**
     * @var integer
     *
     * @ORM\Column(name="siret", type="integer", length=14, nullable=true)
     */
    protected $siret;


    /**
     * @var integer
     *
     * @ORM\Column(name="numtva", type="integer", length=20, nullable=true)
     */
    protected $numtva;


    /**
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="persons")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * })
     */

    protected $user;



    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="person")
     */
    private $invoices;


    /**
     * @var string
     *
     * @ORM\Column(name="person_type", type="string", length=255, nullable=true)
     */
    protected $personType;


//    /**
//     * @ORM\Column(type="string", length=255,nullable=true)
//     * @var string
//     */
//    private $image;
//
//    /**
//     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
//     * @var File
//     */
//    private $imageFile;
//
//    /**
//     * @return File
//     */
//    public function getImageFile()
//    {
//        return $this->imageFile;
//    }
//
//    /**
//     * @param File $imageFile
//     */
//    public function setImageFile(File $imageFile)
//    {
//        $this->imageFile = $imageFile;
//    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->team = new ArrayCollection();
        $this->invoices = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getMobilephone(): ?string
    {
        return $this->mobilephone;
    }

    public function setMobilephone(string $mobilephone): self
    {
        $this->mobilephone = $mobilephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @return string
     */
    public function getSiren(): ?string
    {
        return $this->siren;
    }

    /**
     * @param string $siren
     */
    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    /**
     * @return string
     */
    public function getSiret(): ?string
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     */
    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumtva(): ?string
    {
        return $this->numtva;
    }

    /**
     * @param string $numtva
     */
    public function setNumtva(string $numtva): self
    {
        $this->numtva = $numtva;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyname(): ?string
    {
        return $this->companyname;
    }

    /**
     * @param string $companyname
     */
    public function setCompanyname(string $companyname): self
    {
        $this->companyname = $companyname;

        return $this;
    }

    /**
     * @return int
     */
    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    /**
     * @param int $postcode
     */
    public function setPostcode(int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }


    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }



    /**
     * @return Collection|Team[]
     */
    public function getTeam(): Collection
    {
        return $this->team;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->team->contains($team)) {
            $this->team[] = $team;
            $team->addPerson($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->team->contains($team)) {
            $this->team->removeElement($team);
            $team->removePerson($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPersonType(): ?string
    {
        return $this->personType;
    }

    public function setPersonType(?string $personType): self
    {
        $this->personType = $personType;

        return $this;
    }





    public function __toString(){
        if ($this->getFirstname() != null){
            return $this->getLastname()." ".$this->getFirstname();
        }else{

            return (string)" 🏠 ".$this->getCompanyname();

        }
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
            $invoice->setPerson($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getPerson() === $this) {
                $invoice->setPerson(null);
            }
        }

        return $this;
    }

//    public function getImage(): ?string
//    {
//        return $this->image;
//    }
//
//    public function setImage(?string $image): self
//    {
//        $this->image = $image;
//
//        return $this;
//    }

}
