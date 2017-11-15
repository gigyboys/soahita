<?php

namespace COM\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\PlatformBundle\Entity\Person;

use COM\TrainingBundle\Entity\Student;
use COM\TrainingBundle\Form\Type\StudentInit;
use COM\TrainingBundle\Form\Type\StudentInitType;

class StudentController extends Controller
{
    
	public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		
		$students = $studentRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'students' => $students,
			'treeview' => 'training',
			'treeviewmenu' => 'student',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMTrainingBundle:training:index.html.twig', $data);
    }
	
    public function addStudentAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$studentInit = new StudentInit();
		$formInitStudent = $this->get('form.factory')->create(StudentInitType::class, $studentInit);
		
		if ($formInitStudent->handleRequest($request)->isValid()) {
			
			$person = new Person();
			$student = new Student();
			
			$person->setName($studentInit->getName());
			$person->setFirstname($studentInit->getFirstname());
			$person->setSex($studentInit->getSex());
			$person->setCin($studentInit->getCin());
			
			$date = $platformService->getDate($studentInit->getCindate());
			if($date){
				$person->setCindate($date);
			}else{
				$person->setCindate(null);
			}
			
			$person->setCinlocation($studentInit->getCinlocation());
			
			$person->setAddress($studentInit->getAddress());
			$person->setPhone($studentInit->getPhone());
			$person->setEmail($studentInit->getEmail());
						
			$date = $platformService->getDate($studentInit->getBirthdate());
			if($date){
				$person->setBirthdate($date);
			}else{
				$person->setBirthdate(null);
			}
			
			$person->setBirthlocation($studentInit->getBirthlocation());

			$em->persist($person);
			
			$student->setMatricule($studentInit->getMatricule());
			
			$student->setPerson($person);
			$student->setDeleted(false);

			$em->persist($student);
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout de l'étudiant &quot;".$student->getPerson()->getName()." ".$student->getPerson()->getFirstname()."&quot; est fait avec succès.",
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_student');
			return new RedirectResponse($url);
			
		}
		
        return $this->render('COMTrainingBundle:training:add-student.html.twig', array(
			'form' => $formInitStudent->createView(),
			'treeview' => 'training',
			'treeviewmenu' => 'student',
		));
    }
	
    public function viewStudentAction($student_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		
		$student = $studentRepository->find($student_id);
		$session = $request->getSession();
		
		if($student){
			$studentgroups = $studentgroupRepository->findBy(array(
				'student' => $student,
				'deleted' => false,
			));
			
			$data = array(
				'student' => $student,
				'studentgroups' => $studentgroups,
				'treeview' => 'training',
				'treeviewmenu' => 'student',
				'time' => time(),
			);
			
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMTrainingBundle:training:view-student.html.twig', $data);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à la fiche d'un étudiant qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_student');
			return new RedirectResponse($url);
		}
    }
	
    public function editStudentAction($student_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$student = $studentRepository->find($student_id);
		$session = $request->getSession();
		
		if($student){
			$person = $student->getPerson();
			
			$studentInit = new StudentInit();
			$studentInit->setName($person->getName());
			$studentInit->setFirstname($person->getFirstname());
			$studentInit->setSex($person->getSex());
			$studentInit->setBirthdate($person->getBirthdate());
			$studentInit->setBirthlocation($person->getBirthlocation());
			$studentInit->setCin($person->getCin());
			$studentInit->setCindate($person->getCindate());
			$studentInit->setCinlocation($person->getCinlocation());
			$studentInit->setAddress($person->getAddress());
			$studentInit->setPhone($person->getPhone());
			$studentInit->setEmail($person->getEmail());
			
			$studentInit->setMatricule($student->getMatricule());
			
			$formInitStudent = $this->get('form.factory')->create(StudentInitType::class, $studentInit);
			
			if ($formInitStudent->handleRequest($request)->isValid()) {
				
				$person->setName($studentInit->getName());
				$person->setFirstname($studentInit->getFirstname());
				$person->setSex($studentInit->getSex());
				$person->setCin($studentInit->getCin());
				
				$date = $platformService->getDate($studentInit->getCindate());
				if($date){
					$person->setCindate($date);
				}else{
					$person->setCindate(null);
				}
				
				$person->setCinlocation($studentInit->getCinlocation());
				
				$person->setAddress($studentInit->getAddress());
				$person->setPhone($studentInit->getPhone());
				$person->setEmail($studentInit->getEmail());

				$date = $platformService->getDate($studentInit->getBirthdate());
				if($date){
					$person->setBirthdate($date);
				}else{
					$person->setBirthdate(null);
				}
				$person->setBirthlocation($studentInit->getBirthlocation());

				$em->persist($person);
				
				$student->setMatricule($studentInit->getMatricule());
				$student->setDeleted(false);

				$em->persist($student);
				$em->flush();
				
				$dataTooltip = array(
					'message' => "Modification de l'étudiant &quot;".$student->getPerson()->getName()." ".$student->getPerson()->getFirstname()."&quot; faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_student', array(
					'student_id' => $student->getId(),
				));
				
				return new RedirectResponse($url);
			}
			
			return $this->render('COMTrainingBundle:training:edit-student.html.twig', array(
				'student' => $student,
				'person' => $person,
				'studentInit' => $studentInit,
				'form' => $formInitStudent->createView(),
				'treeview' => 'training',
				'treeviewmenu' => 'student',
			));
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à la fiche d'un étudiant qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_student');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteStudentAction($student_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		
		$student = $studentRepository->find($student_id);
		$session = $request->getSession();
		
		if($student){
			$studentgroups =  $studentgroupRepository->findBy(array(
				'student' => $student,
				'deleted' => false,
			));
			
			if($studentgroups){				
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Cet étudiant est intégré à un ou plusieurs groupes, la suppression n'est pas encore possible.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_student', array(
					'student_id' => $student->getId() ,
				));
			}else{
				$student->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression de l'étudiant &quot;".$student->getPerson()->getName()."&quot; de la liste des étudiants est faite avec succès.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_student');
			}
			return new RedirectResponse($url);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un fiche d'étudiant qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_student');
			return new RedirectResponse($url);
		}
    }
	
    public function generateStudentFormAction($student_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		
		$student = $studentRepository->find($student_id);

		$data = array(
			'student' => $student,
		);

        $template = $this->renderView('COMTrainingBundle:training:generate-student-form.html.twig', $data);
		
		$html2pdf = $this->get('html2pdf_factory')->create();
		$html2pdf->writeHTML($template);
		
		return $html2pdf->Output(time().'_'.$student->getId().'.pdf');
    }
}
