<?php

namespace COM\StaffBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="sf_absence")
 * @ORM\Entity(repositoryClass="COM\StaffBundle\Repository\AbsenceRepository")
 */
class Absence
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
    * @ORM\ManyToOne(targetEntity="COM\StaffBundle\Entity\Employee")
    * @ORM\JoinColumn(nullable=false)
    */
    private $employee;
	
    /**
    * @ORM\ManyToOne(targetEntity="COM\StaffBundle\Entity\Employee")
    * @ORM\JoinColumn(nullable=true)
    */
    private $employeeinterim;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="text", nullable=true)
     */
    private $reason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datebegin", type="datetime")
     */
    private $datebegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateend", type="datetime")
     */
    private $dateend;

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
     * Set reason
     *
     * @param string $reason
     *
     * @return Absence
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set datebegin
     *
     * @param \DateTime $datebegin
     *
     * @return Absence
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
     * @return Absence
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
     * Set employee
     *
     * @param \COM\StaffBundle\Entity\Employee $employee
     *
     * @return Absence
     */
    public function setEmployee(\COM\StaffBundle\Entity\Employee $employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \COM\StaffBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set employeeinterim
     *
     * @param \COM\StaffBundle\Entity\Employee $employeeinterim
     *
     * @return Absence
     */
    public function setEmployeeinterim(\COM\StaffBundle\Entity\Employee $employeeinterim = null)
    {
        $this->employeeinterim = $employeeinterim;

        return $this;
    }

    /**
     * Get employeeinterim
     *
     * @return \COM\StaffBundle\Entity\Employee
     */
    public function getEmployeeinterim()
    {
        return $this->employeeinterim;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Absence
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
