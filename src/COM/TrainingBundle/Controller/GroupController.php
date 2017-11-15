<?php

namespace COM\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\PlatformBundle\Entity\Person;

use COM\TrainingBundle\Entity\Course;
use COM\TrainingBundle\Form\Type\CourseInit;
use COM\TrainingBundle\Form\Type\CourseInitType;

use COM\TrainingBundle\Entity\Group;
use COM\TrainingBundle\Entity\Studentgroup;
use COM\TrainingBundle\Form\Type\StudentgroupInit;
use COM\TrainingBundle\Form\Type\StudentgroupInitType;

use COM\TrainingBundle\Form\Type\GroupInit;
use COM\TrainingBundle\Form\Type\GroupInitType;

use COM\TrainingBundle\Entity\Fee;
use COM\TrainingBundle\Form\Type\FeeInit;
use COM\TrainingBundle\Form\Type\FeeInitType;

class GroupController extends Controller
{
    
	public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		
		$groups = $groupRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'groups' => $groups,
			'treeview' => 'training',
			'treeviewmenu' => 'group',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMTrainingBundle:training:groups.html.twig', $data);
    }
	
    public function addGroupAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		
		$groupInit = new GroupInit();
		
		$courses = $courseRepository->findBy(array(
			'deleted' => false,
		));
		
		$formInitGroup = $this->get('form.factory')->create(GroupInitType::class, $groupInit);
		
		if ($formInitGroup->handleRequest($request)->isValid()) {
			
			$group = new Group();
			
			$group->setName($groupInit->getName());
			
			$course = $courseRepository->find($groupInit->getCourseId());
			$group->setCourse($course);
			
			$group->setPrice($groupInit->getPrice());
			$group->setDescription($groupInit->getDescription());
			$group->setDeleted(false);

			$em->persist($group);
			
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout du groupe &quot;".$group->getName()."&quot; est fait avec succès.",
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
			
		}
		
        return $this->render('COMTrainingBundle:training:add-group.html.twig', array(
			'courses' => $courses,
			'form' => $formInitGroup->createView(),
			'treeview' => 'training',
			'treeviewmenu' => 'group',
		));
    }
	
    public function viewGroupAction($group_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		
		$group = $groupRepository->find($group_id);
		
		if($group){
			$studentgroupInit = new StudentgroupInit();
			$studentgroupInit->setPrice($group->getPrice());
			$formInitStudentgroup = $this->get('form.factory')->create(StudentgroupInitType::class, $studentgroupInit);
			
			if ($formInitStudentgroup->handleRequest($request)->isValid()) {
				
				$studentgroup = new studentgroup();
				
				$studentgroup->setPrice($studentgroupInit->getPrice());
				
				$student = $studentRepository->find($studentgroupInit->getStudentId());
				
				$studentgroup->setStudent($student);
				$studentgroup->setGroup($group);
				$studentgroup->setDeleted(false);
				
				$studentInGroup = $studentgroupRepository->findOneBy(array(
					'group' => $group,
					'student' => $student,
					'deleted' => false,
				));
				
				$session = $request->getSession();
				
				if($studentInGroup){
					$dataTooltip = array(
						'type' => 'warning',
						'message' => "L'étudiant &quot;".$student->getPerson()->getName()." ".$student->getPerson()->getFirstname()."&quot; est déjà dans le groupe.",
					);
				}else{
					$em->persist($studentgroup);
					$em->flush();
					
					$dataTooltip = array(
						'message' => "L'ajout de l'étudiant &quot;".$student->getPerson()->getName()." ".$student->getPerson()->getFirstname()."&quot; dans le groupe est fait avec succès.",
					);
				}
					
				$session->set('dataTooltip', $dataTooltip);
				
			}
			
			/*****************************************************/
			$studentgroups = $studentgroupRepository->findBy(array(
				'group' => $group,
				'deleted' => false,
			));
			
			$students = array();
			
			$studentTemps = $studentRepository->findBy(array(
				'deleted' => false,
			));
			
			foreach($studentTemps as $studentTemp){
				$studentgroup = $studentgroupRepository->findOneBy(array(
					'group' => $group,
					'student' => $studentTemp,
					'deleted' => false,
				));
				if(!$studentgroup){
					array_push($students,$studentTemp);
				}
			}
			
			$data = array(
				'group' => $group,
				'students' => $students,
				'studentgroups' => $studentgroups,
				'studentgroupInit' => $studentgroupInit,
				'treeview' => 'training',
				'treeviewmenu' => 'group',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			return $this->render('COMTrainingBundle:training:view-group.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un groupe qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function editGroupAction($group_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		
		$groupInit = new GroupInit();
		
		$group = $groupRepository->find($group_id);

		if($group){
			$groupInit->setName($group->getName());
			$groupInit->setCourseId($group->getCourse()->getId());
			$groupInit->setPrice($group->getPrice());
			$groupInit->setDescription($group->getDescription());
			
			$courses = $courseRepository->findBy(array(
				'deleted' => false,
			));
			
			$formInitGroup = $this->get('form.factory')->create(GroupInitType::class, $groupInit);
			
			if ($formInitGroup->handleRequest($request)->isValid()) {
				
				$group->setName($groupInit->getName());
				
				$course = $courseRepository->find($groupInit->getCourseId());
				$group->setCourse($course);
				
				$group->setPrice($groupInit->getPrice());
				$group->setDescription($groupInit->getDescription());

				$em->persist($group);
				
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "L'édition du groupe &quot;".$group->getName()."&quot; est faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_group', array(
					'group_id' => $group->getId()
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMTrainingBundle:training:edit-group.html.twig', array(
				'group' => $group,
				'groupInit' => $groupInit,
				'courses' => $courses,
				'form' => $formInitGroup->createView(),
				'treeview' => 'training',
				'treeviewmenu' => 'group',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un groupe qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteGroupAction($group_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		
		$group = $groupRepository->find($group_id);
		
		if($group){
			$studentgroups =  $studentgroupRepository->findBy(array(
				'group' => $group,
				'deleted' => false,
			));
			
			$session = $request->getSession();
			if($studentgroups){				
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Des étudiants sont intégrés dans ce groupe, la suppression n'est pas encore possible.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_group', array(
					'group_id' => $group->getId() ,
				));
			}else{
				$group->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression du groupe de &quot;".$group->getName()."&quot; est faite avec succès.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_group');
			}
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un groupe qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function viewStudentgroupAction($studentgroup_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$studentgroup = $studentgroupRepository->find($studentgroup_id);
		
		if($studentgroup){
			$feeInit = new FeeInit();
			$formInitFee = $this->get('form.factory')->create(FeeInitType::class, $feeInit);
			
			if ($formInitFee->handleRequest($request)->isValid()) {
				
				$fee = new Fee();
				
				$fee->setAmount($feeInit->getAmount());
				
				$fee->setStudentgroup($studentgroup);
				
				$date = $platformService->getDate($feeInit->getPaymentdate());
				if($date){
					$fee->setPaymentdate($date);
				}else{
					$fee->setPaymentdate(null);
				}
				
				$fee->setDescription($feeInit->getDescription());
				$fee->setDeleted(false);
				
				$em->persist($fee);
				
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "Le règlement du frais de &quot;".$fee->getAmount()." Ar &quot; pour le groupe &quot;".$studentgroup->getGroup()->getName()."&quot; est fait avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_studentgroup', array(
					'studentgroup_id' => $studentgroup->getId(),
				));
				return new RedirectResponse($url);
			}
			
			/*****************************************************/
			$fees = $feeRepository->findBy(array(
				'studentgroup' => $studentgroup,
				'deleted' => false,
			));
			
			$data = array(
				'studentgroup' => $studentgroup,
				'fees' => $fees,
				'treeview' => 'training',
				'treeviewmenu' => 'group',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMTrainingBundle:training:view-studentgroup.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une situation qui n'éxiste pas dans un groupe.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function editStudentgroupAction($studentgroup_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		
		$studentgroup = $studentgroupRepository->find($studentgroup_id);
		
		if($studentgroup){
			$studentgroupInit = new StudentgroupInit();

			$studentgroupInit->setPrice($studentgroup->getPrice());
			
			$formInitStudentgroup = $this->get('form.factory')->create(StudentgroupInitType::class, $studentgroupInit);
			
			if ($formInitStudentgroup->handleRequest($request)->isValid()) {
				
				$studentgroup->setPrice($studentgroupInit->getPrice());

				$em->persist($studentgroup);
				
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "L'édition dans le groupe &quot;".$studentgroup->getGroup()->getName()."&quot; est faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_studentgroup', array(
					'studentgroup_id' => $studentgroup->getId()
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMTrainingBundle:training:edit-studentgroup.html.twig', array(
				'studentgroup' => $studentgroup,
				'studentgroupInit' => $studentgroupInit,
				'form' => $formInitStudentgroup->createView(),
				'treeview' => 'training',
				'treeviewmenu' => 'group',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une situation qui n'éxiste pas dans un groupe.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteStudentgroupAction($studentgroup_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		
		$studentgroup = $studentgroupRepository->find($studentgroup_id);
		
		if($studentgroup){
			$fees =  $feeRepository->findBy(array(
				'studentgroup' => $studentgroup,
				'deleted' => false,
			));
			
			$session = $request->getSession();
			if($fees){				
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Des règlements sont liés à cette situation, la suppression n'est pas encore possible.",
				);
				
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_studentgroup', array(
					'studentgroup_id' => $studentgroup->getId() ,
				));
			}else{
				$studentgroup->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression de l'intégration de &quot;".$studentgroup->getStudent()->getPerson()->getName()."&quot; dans le groupe &quot;".$studentgroup->getGroup()->getName()."&quot; est faite avec succès.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_group', array(
					'group_id' => $studentgroup->getGroup()->getId() ,
				));
			}
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une situation qui n'éxiste pas dans un groupe.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function viewFeeAction($fee_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$fee = $feeRepository->find($fee_id);
		
		if($fee){
			
			$data = array(
				'fee' => $fee,
				'treeview' => 'training',
				'treeviewmenu' => 'group',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMTrainingBundle:training:view-fee.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un règlement qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function editFeeAction($fee_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$feeInit = new FeeInit();
		
		$fee = $feeRepository->find($fee_id);
		
		if($fee){
			$feeInit->setPaymentdate($fee->getPaymentdate());
			$feeInit->setAmount($fee->getAmount());
			$feeInit->setDescription($fee->getDescription());
			
			$formInitFee = $this->get('form.factory')->create(FeeInitType::class, $feeInit);
			
			if ($formInitFee->handleRequest($request)->isValid()) {
				
				$date = $platformService->getDate($feeInit->getPaymentdate());
				if($date){
					$fee->setPaymentdate($date);
				}else{
					$fee->setPaymentdate(null);
				}
				
				$fee->setAmount($feeInit->getAmount());
				$fee->setDescription($feeInit->getDescription());

				$em->persist($fee);
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "L'édition du règlement de &quot;".$fee->getAmount()." Ar &quot; est faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_fee', array(
					'fee_id' => $fee->getId()
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMTrainingBundle:training:edit-fee.html.twig', array(
				'fee' => $fee,
				'feeInit' => $feeInit,
				'form' => $formInitFee->createView(),
				'treeview' => 'training',
				'treeviewmenu' => 'group',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un règlement qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteFeeAction($fee_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		
		$fee = $feeRepository->find($fee_id);
		
		if($fee){
			$fee->setDeleted(true);
			$em->flush();
				
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "La suppression du reglement de &quot;".$fee->getAmount()." Ar &quot; est faite avec succès.",
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_view_studentgroup', array(
				'studentgroup_id' => $fee->getStudentgroup()->getId(),
			));
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un règlement qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_group');
			return new RedirectResponse($url);
		}
    }
}
