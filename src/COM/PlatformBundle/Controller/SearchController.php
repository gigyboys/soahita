<?php

namespace COM\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use COM\PlatformBundle\Entity\Person;

use COM\PlatformBundle\Entity\Personimage;
use COM\PlatformBundle\Form\Type\PersonimageType;

class SearchController extends Controller
{
	public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$studentRepository = $em->getRepository('COMTrainingBundle:Student');
        $productRepository = $em->getRepository('COMBusinessBundle:Product');
		
		$q = $request->query->get('q');
		$q = trim($q);
		$session = $request->getSession();
		
		if($q != ""){
			$products = $productRepository->getProductSearch($q);
			$employees = array();
			$students = array();
			
			$persons = $personRepository->getPersonSearch($q);
			
			foreach ($persons as $person) {
				$employee = $employeeRepository->findOneBy(array(
					'person' => $person,
					'deleted' => false,
				));
				
				if($employee){
					array_push($employees,$employee);
				}
			}
			
			foreach ($persons as $person) {
				$student = $studentRepository->findOneBy(array(
					'person' => $person,
					'deleted' => false,
				));
				
				if($student){
					array_push($students,$student);
				}
			}
			
			$data = array(
				'q' => $q,
				'products' => $products,
				'employees' => $employees,
				'students' => $students,
			);
			
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMPlatformBundle:platform:search.html.twig', $data);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Veuillez tapez votre critère de recherche.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_platform_home');
			return new RedirectResponse($url);
		}
    }
}
