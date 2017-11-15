<?php

namespace COM\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table(name="sf_employee")
 * @ORM\Entity(repositoryClass="COM\StaffBundle\Repository\EmployeeRepository")
 */
class Employee
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
	 * @ORM\OneToOne(targetEntity="COM\PlatformBundle\Entity\Person")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $person;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="salary", type="integer")
     */
    private $salary;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="positiondate", type="date")
     */
    private $positiondate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted;


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
     * Set position
     *
     * @param string $position
     *
     * @return Employee
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set salary
     *
     * @param integer $salary
     *
     * @return Employee
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return int
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set positiondate
     *
     * @param \DateTime $positiondate
     *
     * @return Employee
     */
    public function setPositiondate($positiondate)
    {
        $this->positiondate = $positiondate;

        return $this;
    }

    /**
     * Get positiondate
     *
     * @return \DateTime
     */
    public function getPositiondate()
    {
        return $this->positiondate;
    }

    /**
     * Set person
     *
     * @param \COM\PlatformBundle\Entity\Person $person
     *
     * @return Employee
     */
    public function setPerson(\COM\PlatformBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \COM\PlatformBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Employee
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
