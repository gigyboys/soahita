<?php

namespace COM\TrainingBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class CourseInit
{
    private $name;
    private $reference;
    private $price;
    private $description;
	
	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getReference(){
		return $this->reference;
	}

	public function setReference($reference){
		$this->reference = $reference;
	}

	public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}
}
