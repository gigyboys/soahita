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

class CourseController extends Controller
{
    
	public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		
		$courses = $courseRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'courses' => $courses,
			'treeview' => 'training',
			'treeviewmenu' => 'course',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMTrainingBundle:training:courses.html.twig', $data);
    }
	
    public function addCourseAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		
		$courseInit = new CourseInit();
		$formInitCourse = $this->get('form.factory')->create(CourseInitType::class, $courseInit);
		
		if ($formInitCourse->handleRequest($request)->isValid()) {
			
			$course = new Course();
			
			$course->setName($courseInit->getName());
			$course->setReference($courseInit->getReference());
			$course->setPrice($courseInit->getPrice());
			$course->setDescription($courseInit->getDescription());
			$course->setDeleted(false);

			$em->persist($course);
			
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout du cours &quot;".$course->getName()."&quot; est fait avec succès.",
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_course');
			return new RedirectResponse($url);
			
		}
		
        return $this->render('COMTrainingBundle:training:add-course.html.twig', array(
			'form' => $formInitCourse->createView(),
			'treeview' => 'training',
			'treeviewmenu' => 'course',
		));
    }
	
    public function viewCourseAction($course_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		
		$course = $courseRepository->find($course_id);
		
		if($course){
			$groups = $groupRepository->findBy(array(
				'course' => $course,
			));
			
			$data = array(
				'course' => $course,
				'groups' => $groups,
				'treeview' => 'training',
				'treeviewmenu' => 'course',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMTrainingBundle:training:view-course.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un cours qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_course');
			return new RedirectResponse($url);
		}
    }
	
    public function editCourseAction($course_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		
		$course = $courseRepository->find($course_id);
		
		if($course){
			$courseInit = new CourseInit();
			
			$courseInit->setName($course->getName());
			$courseInit->setReference($course->getReference());
			$courseInit->setPrice($course->getPrice());
			$courseInit->setDescription($course->getDescription());
			
			
			$formInitCourse = $this->get('form.factory')->create(CourseInitType::class, $courseInit);
			
			if ($formInitCourse->handleRequest($request)->isValid()) {
				
				$course->setName($courseInit->getName());
				$course->setReference($courseInit->getReference());
				$course->setPrice($courseInit->getPrice());
				$course->setDescription($courseInit->getDescription());

				$em->persist($course);
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "La modification sur le cours &quot;".$course->getName()."&quot; est faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_course', array(
					'course_id' => $course->getId(),
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMTrainingBundle:training:edit-course.html.twig', array(
				'course' => $course,
				'courseInit' => $courseInit,
				'form' => $formInitCourse->createView(),
				'treeview' => 'training',
				'treeviewmenu' => 'course',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un cours qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_course');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteCourseAction($course_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$groupRepository = $em->getRepository('COMTrainingBundle:Group');
		$courseRepository = $em->getRepository('COMTrainingBundle:Course');
		$feeRepository = $em->getRepository('COMTrainingBundle:Fee');
		
		$course = $courseRepository->find($course_id);
		
		if($course){
			$groups =  $groupRepository->findBy(array(
				'course' => $course,
				'deleted' => false,
			));
			
			$session = $request->getSession();
			if($groups){				
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Des groupes sont liés à ce cours, la suppression n'est pas encore possible.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_view_course', array(
					'course_id' => $course->getId() ,
				));
			}else{
				$course->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression du cours de &quot;".$course->getName()."&quot; est faite avec succès.",
				);
			
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_training_course');
			}
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un cours qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_training_course');
			return new RedirectResponse($url);
		}
    }
}
