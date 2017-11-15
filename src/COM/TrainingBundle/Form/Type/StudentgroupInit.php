<?php

namespace COM\TrainingBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class StudentgroupInit
{
    private $studentId;
    private $price;
	
	public function getStudentId(){
		return $this->studentId;
	}

	public function setStudentId($studentId){
		$this->studentId = $studentId;
	}

	public function getPrice(){
		return $this->price;
	}

	public function setPrice($price){
		$this->price = $price;
	}
}
