<?php

namespace COM\TrainingBundle\Service;

use Doctrine\ORM\EntityManager;
use COM\TrainingBundle\Entity\Fee;
use COM\TrainingBundle\Entity\Student;
use COM\TrainingBundle\Entity\Studentgroup;

class TrainingService {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getSumFee(Studentgroup $studentgroup) {
        $feeRepository = $this->em->getRepository('COMTrainingBundle:Fee');

        $fees = $feeRepository->findBy(array(
            'studentgroup' => $studentgroup,
            'deleted' => false,
        ));
		
		$sum = 0;
		
        foreach ($fees as $fee) {
			$sum += $fee->getAmount();
		}
		return $sum;
	
    }
    
    public function getSumRestFee(Student $student) {
        $studentgroupRepository = $this->em->getRepository('COMTrainingBundle:Studentgroup');

        $studentgroups = $studentgroupRepository->findBy(array(
            'student' => $student,
            'deleted' => false,
        ));
		
		$sum = 0;
		
        foreach ($studentgroups as $studentgroup) {
			$sumFees = $this->getSumFee($studentgroup);
			$sum += $studentgroup->getPrice() - $sumFees;
		}
		return $sum;
	
    }

}