<?php

namespace COM\StaffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\PlatformBundle\Entity\Person;

use COM\StaffBundle\Entity\Employee;
use COM\StaffBundle\Form\Type\EmployeeInit;
use COM\StaffBundle\Form\Type\EmployeeInitType;

use COM\StaffBundle\Entity\Absence;
use COM\StaffBundle\Form\Type\AbsenceInit;
use COM\StaffBundle\Form\Type\AbsenceInitType;

class StaffController extends Controller
{
     public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		
		$employees = $employeeRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'employees' => $employees,
			'treeview' => 'staff',
			'treeviewmenu' => 'employee',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMStaffBundle:staff:index.html.twig', $data);
    }
	
    public function addEmployeeAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$employeeInit = new EmployeeInit();
		$formInitEmployee = $this->get('form.factory')->create(EmployeeInitType::class, $employeeInit);
		
		if ($formInitEmployee->handleRequest($request)->isValid()) {
			
			$person = new Person();
			$employee = new Employee();
			
			$person->setName($employeeInit->getName());
			$person->setFirstname($employeeInit->getFirstname());
			$person->setSex($employeeInit->getSex());
			$person->setCin($employeeInit->getCin());
			
			$date = $platformService->getDate($employeeInit->getCindate());
			if($date){
				$person->setCindate($date);
			}else{
				$person->setCindate(null);
			}
			
			$person->setCinlocation($employeeInit->getCinlocation());
			
			$person->setAddress($employeeInit->getAddress());
			$person->setPhone($employeeInit->getPhone());
			$person->setEmail($employeeInit->getEmail());
			
			$date = $platformService->getDate($employeeInit->getBirthdate());
			if($date){
				$person->setBirthdate($date);
			}else{
				$person->setBirthdate(null);
			}
			
			$person->setBirthlocation($employeeInit->getBirthlocation());

			$em->persist($person);
			
			$employee->setPosition($employeeInit->getPosition());
			
			$date = $platformService->getDate($employeeInit->getPositiondate());
			if($date){
				$employee->setPositiondate($date);
			}else{
				$employee->setPositiondate(new \DateTime());
			}
			
			$employee->setSalary($employeeInit->getSalary());
			$employee->setPerson($person);
			$employee->setDeleted(false);

			$em->persist($employee);
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout de l'employé &quot;".$employee->getPerson()->getName()." ".$employee->getPerson()->getFirstname()."&quot; fait avec succès.",
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_home');
			return new RedirectResponse($url);
			
		}
		
        return $this->render('COMStaffBundle:staff:add-employee.html.twig', array(
			'variable' => true,
			'form' => $formInitEmployee->createView(),
			'treeview' => 'staff',
			'treeviewmenu' => 'employee',
		));
    }
	
    public function viewEmployeeAction($employee_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		
		$employee = $employeeRepository->find($employee_id);
		
		if($employee){
			$absences = $absenceRepository->findBy(array(
				'employee' => $employee,
				'deleted' => false,
			));
			
			$interimabsences = $absenceRepository->findBy(array(
				'employeeinterim' => $employee,
				'deleted' => false,
			));
			
			$data = array(
				'employee' => $employee,
				'absences' => $absences,
				'interimabsences' => $interimabsences,
				'treeview' => 'staff',
				'treeviewmenu' => 'employee',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMStaffBundle:staff:view-employee.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un employé qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_home');
			return new RedirectResponse($url);
		}
    }
	
    public function editEmployeeAction($employee_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$employee = $employeeRepository->find($employee_id);
		
		if($employee){
			$person = $employee->getPerson();
			
			$employeeInit = new EmployeeInit();
			$employeeInit->setName($person->getName());
			$employeeInit->setFirstname($person->getFirstname());
			$employeeInit->setSex($person->getSex());
			$employeeInit->setBirthdate($person->getBirthdate());
			$employeeInit->setBirthlocation($person->getBirthlocation());
			$employeeInit->setCin($person->getCin());
			$employeeInit->setCinlocation($person->getCinlocation());
			$employeeInit->setAddress($person->getAddress());
			$employeeInit->setPhone($person->getPhone());
			$employeeInit->setEmail($person->getEmail());
			
			$employeeInit->setPosition($employee->getPosition());
			$employeeInit->setPositiondate($employee->getPositiondate());
			$employeeInit->setSalary($employee->getSalary());
			
			$formInitEmployee = $this->get('form.factory')->create(EmployeeInitType::class, $employeeInit);
			
			if ($formInitEmployee->handleRequest($request)->isValid()) {
				
				$person->setName($employeeInit->getName());
				$person->setFirstname($employeeInit->getFirstname());
				$person->setSex($employeeInit->getSex());
				$person->setCin($employeeInit->getCin());			
				
				$date = $platformService->getDate($employeeInit->getCindate());
				if($date){
					$person->setCindate($date);
				}else{
					$person->setCindate(null);
				}
				
				$person->setCinlocation($employeeInit->getCinlocation());
				
				$person->setAddress($employeeInit->getAddress());
				$person->setPhone($employeeInit->getPhone());
				$person->setEmail($employeeInit->getEmail());
				
				
				$date = $platformService->getDate($employeeInit->getBirthdate());
				if($date){
					$person->setBirthdate($date);
				}else{
					$person->setBirthdate(null);
				}
				
				$person->setBirthlocation($employeeInit->getBirthlocation());

				$em->persist($person);
				
				$employee->setPosition($employeeInit->getPosition());
				
				$date = $platformService->getDate($employeeInit->getPositiondate());
				if($date){
					$employee->setPositiondate($date);
				}else{
					$employee->setPositiondate(new \DateTime());
				}
				
				$employee->setSalary($employeeInit->getSalary());
				$employee->setPerson($person);
				$employee->setDeleted(false);

				$em->persist($employee);
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "Modification de l'employé &quot;".$employee->getPerson()->getName()." ".$employee->getPerson()->getFirstname()."&quot; faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_staff_view_employee', array(
					'employee_id' => $employee->getId()
				));
				
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMStaffBundle:staff:edit-employee.html.twig', array(
				'employee' => $employee,
				'person' => $person,
				'employeeInit' => $employeeInit,
				'form' => $formInitEmployee->createView(),
				'treeview' => 'staff',
				'treeviewmenu' => 'employee',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un employé qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_home');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteEmployeeAction($employee_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$employee = $employeeRepository->find($employee_id);
		
		if($employee){
			$absences =  $absenceRepository->findBy(array(
				'employee' => $employee,
				'deleted' => false,
			));
			$absenceinterims =  $absenceRepository->findBy(array(
				'employeeinterim' => $employee,
				'deleted' => false,
			));
			
			$session = $request->getSession();
			if($absences || $absenceinterims){
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Des absences sont liées à cet employé, la suppression n'est pas encore possible.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_staff_view_employee', array(
					'employee_id' => $employee->getId() ,
				));
			}else{
				$employee->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression de &quot;".$employee->getPerson()->getName()."&quot; de la liste des employés est faite avec succès.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_staff_home');
			}
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un fiche d'employé qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_home');
			return new RedirectResponse($url);
		}
    }
	
    public function absenceAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		
		$absences = $absenceRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'absences' => $absences,
			'treeview' => 'staff',
			'treeviewmenu' => 'absence',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMStaffBundle:staff:absence.html.twig', $data);
    }
	
    public function addAbsenceAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$absenceInit = new AbsenceInit();
		$formInitAbsence = $this->get('form.factory')->create(AbsenceInitType::class, $absenceInit);
		
		if ($formInitAbsence->handleRequest($request)->isValid()) {
			
			$hasError = false;
			$errors = array();
			$absence = new Absence();
			
			$employee = $employeeRepository->find($absenceInit->getEmployeeId());
			$employeeinterim = $employeeRepository->find($absenceInit->getEmployeeinterimId());
			
			if($absenceInit->getEmployeeId() == $absenceInit->getEmployeeinterimId()){
				$hasError = true;
				$errors [] = "L'employé prévu pour l'absence doit être différent de l'employé interim.";
			}
			
			$absence->setEmployee($employee);
			$absence->setEmployeeinterim($employeeinterim);
			
			$date = $platformService->getDate($absenceInit->getDatebegin(), 'd/m/y h:i');
			if($date){
				$absence->setDatebegin($date);
			}else{
				$absence->setDatebegin(new \DateTime());
			}
			
			$date = $platformService->getDate($absenceInit->getDateend(), 'd/m/y h:i');
			if($date){
				$absence->setDateend($date);
			}else{
				$absence->setDateend(new \DateTime());
			}
			
			
			if($absence->getDatebegin() >= $absence->getDateend()){
				$hasError = true;
				$errors [] = "La date et heure debut doit être antérieure à la date et heure fin.";
			}
			
			$absence->setReason($absenceInit->getReason());
	
			if(!$hasError){
				$absence->setDeleted(false);
				$em->persist($absence);
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "L'ajout d'une absence pour l'employé &quot;".$employee->getPerson()->getName()." ".$employee->getPerson()->getFirstname()."&quot; est fait avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_staff_absence');
				return new RedirectResponse($url);
			}else{
				$messageError = "";
				foreach ($errors as $error) {
					$messageError .= " ".$error;
				}
				$session = $request->getSession();
				$dataTooltip = array(
					'type' => 'error',
					'message' => "Veuillez bien remplir les champs.".$messageError,
				);
				$session->set('dataTooltip', $dataTooltip);
			}
			
		}
		
		$employees = $employeeRepository->findAll();
		
		$data = array(
			'employees' => $employees,
			'absenceInit' => $absenceInit,
			'form' => $formInitAbsence->createView(),
			'treeview' => 'staff',
			'treeviewmenu' => 'absence',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMStaffBundle:staff:add-absence.html.twig', $data);
    }
	
    public function viewAbsenceAction($absence_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		
		$absence = $absenceRepository->find($absence_id);
		
		if($absence){
			$data = array(
				'absence' => $absence,
				'treeview' => 'staff',
				'treeviewmenu' => 'employee',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMStaffBundle:staff:view-absence.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une absence qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_absence');
			return new RedirectResponse($url);
		}
    }
	
    public function editAbsenceAction($absence_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$absence = $absenceRepository->find($absence_id);
		
		if($absence){
			$employee = $absence->getEmployee();
			$employeeinterim = $absence->getEmployeeinterim();
			
			$absenceInit = new AbsenceInit();
			$absenceInit->setEmployeeId($employee->getId());
			$absenceInit->setEmployeeinterimId($employeeinterim->getId());
			$absenceInit->setDatebegin($absence->getDatebegin());
			$absenceInit->setReason($absence->getReason());
			
			$formInitAbsence = $this->get('form.factory')->create(AbsenceInitType::class, $absenceInit);
			
			if ($formInitAbsence->handleRequest($request)->isValid()) {
				
				$hasError = false;
				$errors = array();
				
				$employee = $employeeRepository->find($absenceInit->getEmployeeId());
				$employeeinterim = $employeeRepository->find($absenceInit->getEmployeeinterimId());
				
				if($absenceInit->getEmployeeId() == $absenceInit->getEmployeeinterimId()){
					$hasError = true;
					$errors [] = "L'employé prévu pour l'absence doit être différent de l'employé interim.";
				}
				
				$absence->setEmployee($employee);
				$absence->setEmployeeinterim($employeeinterim);
				
				$date = $platformService->getDate($absenceInit->getDatebegin(), 'd/m/y h:i');
				if($date){
					$absence->setDatebegin($date);
				}else{
					$absence->setDatebegin(new \DateTime());
				}
			
				$date = $platformService->getDate($absenceInit->getDateend(), 'd/m/y h:i');
				if($date){
					$absence->setDateend($date);
				}else{
					$absence->setDateend(new \DateTime());
				}
					
				$absenceInit->setDatebegin($absence->getDatebegin());
				$absenceInit->setDateend($absence->getDateend());
				
				if($absence->getDatebegin() >= $absence->getDateend()){
					$hasError = true;
					$errors [] = "La date et heure debut doit être antérieure à la date et heure fin.";
				}
				
				$absence->setReason($absenceInit->getReason());
		
				if(!$hasError){
					$em->persist($absence);
					$em->flush();
					
					$session = $request->getSession();
					$dataTooltip = array(
						'message' => "L'édition de l'absence pour l'employé &quot;".$employee->getPerson()->getName()." ".$employee->getPerson()->getFirstname()."&quot; est fait avec succès.",
					);
					$session->set('dataTooltip', $dataTooltip);
					
					$data = array(
						'absence_id' => $absence->getId(),
					);
					
					$url = $this->get('router')->generate('com_staff_view_absence', $data);
					return new RedirectResponse($url);
				}else{
					$messageError = "";
					foreach ($errors as $error) {
						$messageError .= " ".$error;
					}
					$session = $request->getSession();
					$dataTooltip = array(
						'type' => 'error',
						'message' => "Veuillez bien remplir les champs.".$messageError,
					);
					$session->set('dataTooltip', $dataTooltip);
				}
				
			}
			
			$employees = $employeeRepository->findAll();
			
			$data = array(
				'absence' => $absence,
				'employee' => $employee,
				'employees' => $employees,
				'absenceInit' => $absenceInit,
				'form' => $formInitAbsence->createView(),
				'treeview' => 'staff',
				'treeviewmenu' => 'absence',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMStaffBundle:staff:edit-absence.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une absence qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_absence');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteAbsenceAction($absence_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$absenceRepository = $em->getRepository('COMStaffBundle:Absence');
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$absence = $absenceRepository->find($absence_id);
		
		if($absence){
			$absence->setDeleted(true);
			$em->flush();
				
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "La suppression de l'absence pour l'employé &quot;".$absence->getEmployee()->getPerson()->getName()."&quot; est faite avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_absence');
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une absence qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_staff_absence');
			return new RedirectResponse($url);
		}
    }
	
}
