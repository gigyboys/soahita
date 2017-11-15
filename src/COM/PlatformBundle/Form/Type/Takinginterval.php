<?php

namespace COM\PlatformBundle\Form\Type;

use Doctrine\ORM\Mapping as ORM;


class Takinginterval
{
    private $datebegin;
    private $dateend;
	
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
}
