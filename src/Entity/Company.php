<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Company
 *
 * @ORM\Table(name="Company")
 * @ORM\Entity
 */
class   Company
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
     * @ORM\Column(name="siren", type="integer", length=255, nullable=false)
     */
    private $siren;


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


}