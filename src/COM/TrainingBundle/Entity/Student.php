<?php

namespace COM\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="tg_student")
 * @ORM\Entity(repositoryClass="COM\TrainingBundle\Repository\StudentRepository")
 */
class Student
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
     * @ORM\Column(name="matricule", type="string", length=255)
     */
    private $matricule;

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
     * Set person
     *
     * @param \COM\PlatformBundle\Entity\Person $person
     *
     * @return Student
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
     * Get datecourse
     *
     * @return \DateTime
     */
    public function getDatecourse()
    {
        return $this->datecourse;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Student
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Student
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
