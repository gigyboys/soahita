<?php

namespace COM\StaffBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class EmployeeInit
{
    private $name;
    private $firstname;
    private $sex;
    private $birthdate;
    private $birthlocation;
    private $cin;
    private $cindate;
    private $cinlocation;
    private $address;
    private $phone;
    private $email;
    private $position;
    private $positiondate;
    private $salary;
	
	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getFirstname(){
		return $this->firstname;
	}

	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}

	public function getSex(){
		return $this->sex;
	}

	public function setSex($sex){
		$this->sex = $sex;
	}

	public function getBirthdate(){
		return $this->birthdate;
	}

	public function setBirthdate($birthdate){
		$this->birthdate = $birthdate;
	}

	public function getBirthlocation(){
		return $this->birthlocation;
	}

	public function setBirthlocation($birthlocation){
		$this->birthlocation = $birthlocation;
	}

	public function getCin(){
		return $this->cin;
	}

	public function setCin($cin){
		$this->cin = $cin;
	}

	public function getCindate(){
		return $this->cindate;
	}

	public function setCindate($cindate){
		$this->cindate = $cindate;
	}

	public function getCinlocation(){
		return $this->cinlocation;
	}

	public function setCinlocation($cinlocation){
		$this->cinlocation = $cinlocation;
	}

	public function getAddress(){
		return $this->address;
	}

	public function setAddress($address){
		$this->address = $address;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($phone){
		$this->phone = $phone;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getPosition(){
		return $this->position;
	}

	public function setPosition($position){
		$this->position = $position;
	}

	public function getPositiondate(){
		return $this->positiondate;
	}

	public function setPositiondate($positiondate){
		$this->positiondate = $positiondate;
	}

	public function getSalary(){
		return $this->salary;
	}

	public function setSalary($salary){
		$this->salary = $salary;
	}
}
