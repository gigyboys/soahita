<?php

namespace COM\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="pm_person")
 * @ORM\Entity(repositoryClass="COM\PlatformBundle\Repository\PersonRepository")
 */
class Person
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var int
     *
     * @ORM\Column(name="sex", type="integer")
     */
    private $sex;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="birthlocation", type="string", length=255, nullable=true)
     */
    private $birthlocation;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", nullable=true)
     */
    private $cin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cindate", type="date", nullable=true)
     */
    private $cindate;

    /**
     * @var string
     *
     * @ORM\Column(name="cinlocation", type="string", length=255, nullable=true)
     */
    private $cinlocation;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;


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
     * Set name
     *
     * @param string $name
     *
     * @return Person
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     *
     * @return Person
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set cin
     *
     * @param string $cin
     *
     * @return Person
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set cindate
     *
     * @param \DateTime $cindate
     *
     * @return Person
     */
    public function setCindate($cindate)
    {
        $this->cindate = $cindate;

        return $this;
    }

    /**
     * Get cindate
     *
     * @return \DateTime
     */
    public function getCindate()
    {
        return $this->cindate;
    }

    /**
     * Set cinlocation
     *
     * @param string $cinlocation
     *
     * @return Person
     */
    public function setCinlocation($cinlocation)
    {
        $this->cinlocation = $cinlocation;

        return $this;
    }

    /**
     * Get cinlocation
     *
     * @return string
     */
    public function getCinlocation()
    {
        return $this->cinlocation;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return Person
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set birthlocation
     *
     * @param string $birthlocation
     *
     * @return Person
     */
    public function setBirthlocation($birthlocation)
    {
        $this->birthlocation = $birthlocation;

        return $this;
    }

    /**
     * Get birthlocation
     *
     * @return string
     */
    public function getBirthlocation()
    {
        return $this->birthlocation;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Person
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

