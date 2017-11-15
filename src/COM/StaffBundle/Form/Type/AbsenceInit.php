<?php

namespace COM\StaffBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class AbsenceInit
{
    private $employeeId;
    private $employeeinterimId;
    private $datebegin;
    private $dateend;
    private $reason;
	
	public function getEmployeeId(){
		return $this->employeeId;
	}

	public function setEmployeeId($employeeId){
		$this->employeeId = $employeeId;
	}

	public function getEmployeeinterimId(){
		return $this->employeeinterimId;
	}

	public function setEmployeeinterimId($employeeinterimId){
		$this->employeeinterimId = $employeeinterimId;
	}

	public function getDatebegin(){
		return $this->datebegin;
	}

	public function setDatebegin($datebegin){
		$this->datebegin = $datebegin;
	}

	public function getDateend(){
		return $this->dateend;
	}

	public function setDateend($dateend){
		$this->dateend = $dateend;
	}

	public function getReason(){
		return $this->reason;
	}

	public function setReason($reason){
		$this->reason = $reason;
	}
}
