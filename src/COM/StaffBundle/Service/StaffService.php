<?php

namespace COM\StaffBundle\Service;

use Doctrine\ORM\EntityManager;
use COM\StaffBundle\Entity\Employee;
use COM\StaffBundle\Entity\Absence;

class StaffService {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function isPresent(Employee $employee) {
		$employeeRepository = $this->em->getRepository('COMStaffBundle:Employee');
		$absenceRepository = $this->em->getRepository('COMStaffBundle:Absence');
		
		$absences = $absenceRepository->getCurrentAbsencesByEmployee($employee);

		if ($absences) {
			return false;
		}
		
		return true;
    }
}