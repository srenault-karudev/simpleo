<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Statut
 *
 * @ORM\Table(name="statut")
 * @ORM\Entity
 */
class Statut
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=true)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="long_name", type="string", length=128, nullable=true)
     */
    private $longName;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function __toString()
    {
        return $this->name;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Statut
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set longName
     *
     * @param string $longName
     *
     * @return Statut
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;
        return $this;
    }
    /**
     * Get longName
     *
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }
}