<?php

namespace COM\PlatformBundle\Service;

use Doctrine\ORM\EntityManager;
use COM\PlatformBundle\Entity\Person;

class PlatformService {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getPersonimage(Person $person) {
        $personimageRepository = $this->em->getRepository('COMPlatformBundle:Personimage');

        $personimage = $personimageRepository->findOneBy(array(
            'person' => $person,
            'current' => true,
        ));

        if($personimage){
            return $personimage->getWebPath();
        }
        else{
            if($person->getSex() == 0){
				return 'default/image/person/defaultman.png';
			}elseif($person->getSex() == 1){
				return 'default/image/person/defaultwoman.png';
			}else{
				return 'default/image/person/default.png';
			}
        }
    }
	
    public function substrSpace($string, $length) {
		if(strlen($string)>$length){
			$string = substr($string, 0, $length);
			$posLastSpace = strrpos($string, " ");
			$string = substr($string, 0, $posLastSpace);
			$string = $string."...";
		}
		return $string;
    }
	
    public function formatAmount($amount) {
		//$amount = number_format((double)$amount, "2", ",", " ");
		$amount = number_format((double)$amount, "0", ",", " ");
		return $amount;
    }
	
    public function getDate($dateString, $format = 'd/m/y') {
		$year = 0;
		$month = 0;
		$day = 0;
		$hour = 0;
		$minute = 0;
		$second = 0;
		
		$isDate = false;
		$isTime = false;
		$date = null;
		
		$dateString = trim(preg_replace('!\s+!', ' ', $dateString));
		switch ($format) {
			case 'd/m/y':
				$dateArray = explode("/", $dateString);
				if(count($dateArray) == 3){
					$year = intval($dateArray[2]);
					$month = intval($dateArray[1]);
					$day = intval($dateArray[0]);
				}
			break;
			case 'd-m-y':
				$dateArray = explode("-", $dateString);
				if(count($dateArray) == 3){
					$year = intval($dateArray[2]);
					$month = intval($dateArray[1]);
					$day = intval($dateArray[0]);
				}
			break;
			case 'd/m/y h:i':
				$dateTimeArray = explode(" ", $dateString);
				if(count($dateTimeArray) == 2){
					//date
					$dateArray = explode("/", $dateTimeArray[0]);
					if(count($dateArray) == 3){
						$year = intval($dateArray[2]);
						$month = intval($dateArray[1]);
						$day = intval($dateArray[0]);
					}
					//time
					$timeArray = explode(":", $dateTimeArray[1]);
					if(count($timeArray) == 2){
						$hour = intval($timeArray[0]);
						$minute = intval($timeArray[1]);
					}
				}
			break;
			case 'd-m-y h:i':
				$dateTimeArray = explode(" ", $dateString);
				if(count($dateTimeArray) == 2){
					//date
					$dateArray = explode("-", $dateTimeArray[0]);
					if(count($dateArray) == 3){
						$year = intval($dateArray[2]);
						$month = intval($dateArray[1]);
						$day = intval($dateArray[0]);
					}
					//time
					$timeArray = explode(":", $dateTimeArray[1]);
					if(count($timeArray) == 2){
						$hour = intval($timeArray[0]);
						$minute = intval($timeArray[1]);
					}
				}
			break;
		}
		
		//checking date
		if($year >= 1000 && $year <= 9999){
			if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12 ){
				if($day >= 1 && $day <= 31 ){
					$isDate = true;
				}
			}elseif($month == 4 || $month == 6 || $month == 9 || $month == 11 ){
				if($day >= 1 && $day <= 30 ){
					$isDate = true;
				}
			}elseif($month == 2 ){
				if($day >= 1 && $day <= 28 ){
					$isDate = true;
				}elseif($day == 29 ){
					if (($year % 4) == 0){ 
						$isDate = true;
					}
				}
			}
		}
		
		//checking time
		if($hour >= 0 && $hour <= 23 && $minute >= 0 && $minute <= 59){
			$isTime = true;
		}
		
		if($isDate && $isTime){
			$date = new \DateTime($year."-".$month."-".$day." ".$hour.":".$minute.":".$second);
		}
		
		return $date;
    }
	   
	function sluggify($str) {

        $before = array(
            '/[^a-z0-9\s]/',
            array(
				'/\s/',
				'/--+/',
				'/---+/'),
            '/\&/'
        );

        $after = '-';
        
		$str = str_replace("’", "-", $str);
		$str = str_replace("–", "-", $str);
		$str = str_replace("«", "-", $str);
		$str = str_replace("»", "-", $str);
        $str = preg_replace($before[2], $after, $str);
        $str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
    
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'

        $str = strtolower($str);
        $str = preg_replace($before[0], $after, $str);
        $str = trim($str);
        $str = preg_replace($before[1], $after, $str);
        $str = trim($str, '-');
		
		//get 240 characters
		$str = substr($str, 0, 240);  // bcd

        return $str;
    }
	
	/*
	*generate random string
	*/
	function generateRandomString($length = 32) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

}