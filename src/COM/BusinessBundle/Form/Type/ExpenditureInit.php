<?php

namespace COM\BusinessBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class ExpenditureInit
{
    private $name;
    private $amount;
    private $date;
    private $description;
	
	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getAmount(){
		return $this->amount;
	}

	public function setAmount($amount){
		$this->amount = $amount;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}
}
