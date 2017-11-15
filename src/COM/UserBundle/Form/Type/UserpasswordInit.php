<?php

namespace COM\UserBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class UserpasswordInit
{
    private $currentpassword;
    private $newpassword;
    private $repeatedpassword;
	
	public function getCurrentpassword(){
		return $this->currentpassword;
	}

	public function setCurrentpassword($currentpassword){
		$this->currentpassword = $currentpassword;
	}

	public function getNewpassword(){
		return $this->newpassword;
	}

	public function setNewpassword($newpassword){
		$this->newpassword = $newpassword;
	}

	public function getRepeatedpassword(){
		return $this->repeatedpassword;
	}

	public function setRepeatedpassword($repeatedpassword){
		$this->repeatedpassword = $repeatedpassword;
	}
}
