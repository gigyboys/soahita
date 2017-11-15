<?php

namespace COM\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fee
 *
 * @ORM\Table(name="tg_fee")
 * @ORM\Entity(repositoryClass="COM\TrainingBundle\Repository\FeeRepository")
 */
class Fee
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
    * @ORM\ManyToOne(targetEntity="COM\TrainingBundle\Entity\Studentgroup")
    * @ORM\JoinColumn(nullable=false)
    */
    private $studentgroup;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paymentdate", type="date")
     */
    private $paymentdate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * Set studentgroup
     *
     * @param \COM\TrainingBundle\Entity\Studentgroup $studentgroup
     *
     * @return Fee
     */
    public function setStudentgroup(\COM\TrainingBundle\Entity\Studentgroup $studentgroup)
    {
        $this->studentgroup = $studentgroup;

        return $this;
    }

    /**
     * Get studentgroup
     *
     * @return \COM\TrainingBundle\Entity\Studentgroup
     */
    public function getStudentgroup()
    {
        return $this->studentgroup;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return Fee
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
     * Set paymentdate
     *
     * @param \DateTime $paymentdate
     *
     * @return Fee
     */
    public function setPaymentdate($paymentdate)
    {
        $this->paymentdate = $paymentdate;

        return $this;
    }

    /**
     * Get paymentdate
     *
     * @return \DateTime
     */
    public function getPaymentdate()
    {
        return $this->paymentdate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Fee
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

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return Fee
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

