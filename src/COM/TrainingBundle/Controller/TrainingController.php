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

class TrainingController extends Controller
{
    
	public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
		
		$students = $studentRepository->findBy(array(
			'deleted' => false,
		));
		
		$session = $request->getSession();
		$dataStudent = $session->get('dataStudent');
		
		if($dataStudent["state"]){			
			$data = array(
				'students' => $students,
				'showTooltip' => true,
				'message' => $dataStudent["message"],
				'treeview' => 'training',
				'treeviewmenu' => 'student',
			);
			
			$session->remove('dataStudent');
		}else{
			$data = array(
				'students' => $students,
				'treeview' => 'training',
				'treeviewmenu' => 'student',
			);
		}
		
        return $this->render('COMTrainingBundle:training:index.html.twig', $data);
    }
}
