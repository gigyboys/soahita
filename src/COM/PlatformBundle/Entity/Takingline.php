<?php

namespace COM\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Takingline
 *
 * @ORM\Table(name="pm_takingline")
 * @ORM\Entity(repositoryClass="COM\PlatformBundle\Repository\TakinglineRepository")
 */
class Takingline
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
    /**
    * @ORM\ManyToOne(targetEntity="COM\PlatformBundle\Entity\Taking")
    * @ORM\JoinColumn(nullable=false)
    */
    private $taking;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="entity", type="text")
     */
    private $entity;

    /**
     * @var int
     *
     * @ORM\Column(name="entityid", type="integer")
     */
    private $entityid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set taking
     *
     * @param \COM\PlatformBundle\Entity\Taking $taking
     *
     * @return Takingline
     */
    public function setTaking(\COM\PlatformBundle\Entity\Taking $taking)
    {
        $this->taking = $taking;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Takingline
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
     * Set entity
     *
     * @param string $name
     *
     * @return Takingline
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set entityid
     *
     * @param string $name
     *
     * @return Takingline
     */
    public function setEntityid($entityid)
    {
        $this->entityid = $entityid;

        return $this;
    }

    /**
     * Get entityid
     *
     * @return string
     */
    public function getEntityid()
    {
        return $this->entityid;
    }

    /**
     * Get taking
     *
     * @return \COM\PlatformBundle\Entity\Taking
     */
    public function getTaking()
    {
        return $this->taking;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Takingline
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return Takingline
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Takingline
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Takingline
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

