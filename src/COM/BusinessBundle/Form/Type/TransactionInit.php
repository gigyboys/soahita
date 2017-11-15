<?php

namespace COM\BusinessBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class TransactionInit
{
    private $transactionTypeId;
    private $date;
    private $amount;
    private $description;
	
    public function setTransactionTypeId($transactionTypeId)
    {
        $this->transactionTypeId = $transactionTypeId;

        return $this;
    }

    public function getTransactionTypeId()
    {
        return $this->transactionTypeId;
    }
	
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }
	
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }
	
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
