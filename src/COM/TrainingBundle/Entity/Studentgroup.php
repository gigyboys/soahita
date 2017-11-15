<?php

namespace COM\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Studentgroup
 *
 * @ORM\Table(name="tg_studentgroup")
 * @ORM\Entity(repositoryClass="COM\TrainingBundle\Repository\StudentgroupRepository")
 */
class Studentgroup
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
    * @ORM\ManyToOne(targetEntity="COM\TrainingBundle\Entity\Student")
    * @ORM\JoinColumn(nullable=false)
    */
    private $student;
	
    /**
    * @ORM\ManyToOne(targetEntity="COM\TrainingBundle\Entity\Group")
    * @ORM\JoinColumn(nullable=false)
    */
    private $group;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

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
     * Set group
     *
     * @param \COM\TrainingBundle\Entity\Group $group
     *
     * @return Studentgroup
     */
    public function setGroup(\COM\TrainingBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \COM\TrainingBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Studentgroup
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set student
     *
     * @param \COM\TrainingBundle\Entity\Student $student
     *
     * @return Studentgroup
     */
    public function setStudent(\COM\TrainingBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \COM\TrainingBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Studentgroup
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

