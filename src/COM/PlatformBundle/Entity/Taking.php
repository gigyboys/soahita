<?php

namespace COM\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taking
 *
 * @ORM\Table(name="pm_taking")
 * @ORM\Entity(repositoryClass="COM\PlatformBundle\Repository\TakingRepository")
 */
class Taking
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datebegin", type="date")
     */
    private $datebegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateend", type="date")
     */
    private $dateend;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var bool
     *
     * @ORM\Column(name="state", type="boolean")
     */
    private $state;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Taking
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
     * Set datebegin
     *
     * @param \DateTime $datebegin
     *
     * @return Taking
     */
    public function setDatebegin($datebegin)
    {
        $this->datebegin = $datebegin;

        return $this;
    }

    /**
     * Get datebegin
     *
     * @return \DateTime
     */
    public function getDatebegin()
    {
        return $this->datebegin;
    }

    /**
     * Set dateend
     *
     * @param \DateTime $dateend
     *
     * @return Taking
     */
    public function setDateend($dateend)
    {
        $this->dateend = $dateend;

        return $this;
    }

    /**
     * Get dateend
     *
     * @return \DateTime
     */
    public function getDateend()
    {
        return $this->dateend;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Taking
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set state
     *
     * @param boolean $state
     *
     * @return Taking
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }
}

