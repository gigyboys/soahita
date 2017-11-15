<?php

namespace COM\TrainingBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class FeeInit
{
    private $paymentdate;
    private $amount;
    private $description;
	
	public function getPaymentdate(){
		return $this->paymentdate;
	}

	public function setPaymentdate($paymentdate){
		$this->paymentdate = $paymentdate;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function setAmount($amount){
		$this->amount = $amount;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}
}
