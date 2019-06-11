<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Company
 *
 * @ORM\Table(name="Company")
 * @ORM\Entity
 *  @Vich\Uploadable
 */
class Company
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */

    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="social_reason", type="string", length=255, nullable=false)
     */
    private $socialReason;


    /**
     * @var string
     *
     * @ORM\Column(name="legal_form", type="string", length=255, nullable=false)
     */
    private $legalForm;

    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="string", length=255, nullable=false)
     */
    private $tva;


    /**
     * @var integer
     *
     * @ORM\Column(name="siren", type="integer", length=9, nullable=false)
     * @Assert\Length(
     *     max=9,
     *     maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $siren;

    /**
     * @var integer
     *
     * @ORM\Column(name="siret", type="integer", length=14, nullable=true)
     */
    private $siret;


    /**
     * @var string
     *
     * @ORM\Column(name="mobilePhone", type="string", length=255, nullable=true)
     */
    private $mobilephone;


    /**
     * @var string
     *
     * @ORM\Column(name="declaration", type="string", length=255, nullable=false)
     */
    private $declaration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date_social_year", type="date", nullable=false)
     */
    private $startDateSocialYear;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date_social_year", type="date", nullable=false)
     */
    private $endDateSocialYear;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User",inversedBy="company")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;



    /**
     * @var integer
     *
     * @ORM\Column(name="postcode", type="integer", length=255, nullable=true)
     */
    private $postcode;


    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;


    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;


        /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;
    }


        public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    /**
     * @param string $socialReason
     */
    public function setSocialReason(string $socialReason)
    {
        $this->socialReason = $socialReason;
    }

    /**
     * @return string
     */
    public function getLegalForm(): ?string
    {
        return $this->legalForm;
    }

    /**
     * @param string $legalForm
     */
    public function setLegalForm(string $legalForm)
    {
        $this->legalForm = $legalForm;
    }

    /**
     * @return string
     */
    public function getTva(): ?string
    {
        return $this->tva;
    }

    /**
     * @param string $tva
     */
    public function setTva(string $tva)
    {
        $this->tva = $tva;
    }

    /**
     * @return string
     */
    public function getDeclaration(): ?string
    {
        return $this->declaration;
    }

    /**
     * @param string $declaration
     */
    public function setDeclaration(string $declaration)
    {
        $this->declaration = $declaration;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateSocialYear(): ?\DateTime
    {
        return $this->startDateSocialYear;
    }

    /**
     * @param \DateTime $startDateSocialYear
     */
    public function setStartDateSocialYear(\DateTime $startDateSocialYear)
    {
        $this->startDateSocialYear = $startDateSocialYear;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateSocialYear(): ?\DateTime
    {
        return $this->endDateSocialYear;
    }

    /**
     * @param \DateTime $endDateSocialYear
     */
    public function setEndDateSocialYear(\DateTime $endDateSocialYear)
    {
        $this->endDateSocialYear = $endDateSocialYear;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSiren(): ?int
    {
        return $this->siren;
    }

    public function setSiren(int $siren): self
    {
        $this->siren = $siren;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

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

    public function getMobilephone(): ?string
    {
        return $this->mobilephone;
    }

    public function setMobilephone(string $mobilephone): self
    {
        $this->mobilephone = $mobilephone;

        return $this;
    }
}