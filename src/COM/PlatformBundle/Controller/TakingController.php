<?php

namespace COM\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\PlatformBundle\Entity\Taking;
use COM\PlatformBundle\Entity\Takingline;

use COM\PlatformBundle\Form\Type\Takinginterval;
use COM\PlatformBundle\Form\Type\TakingintervalType;

class TakingController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$takingRepository = $em->getRepository('COMPlatformBundle:Taking');
		$takinglineRepository = $em->getRepository('COMPlatformBundle:Takingline');
		
		$businessService = $this->container->get('com_business.business_service');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$takinginterval = new Takinginterval();
		$formTakinginterval = $this->get('form.factory')->create(TakingintervalType::class, $takinginterval);
		
		if ($formTakinginterval->handleRequest($request)->isValid()) {
			$date = $platformService->getDate($takinginterval->getDatebegin());
			if($date){
				$datebeginTemp = $date;
			}else{
				$datebeginTemp = new \DateTime();
			}
			
			$date = $platformService->getDate($takinginterval->getDateend());
			if($date){
				$dateendTemp = $date;
			}else{
				$dateendTemp = new \DateTime();
			}
			
			if($datebeginTemp <= $dateendTemp){
				$datebegin = $datebeginTemp;
				$dateend = $dateendTemp;
			}else{
				$datebegin = $dateendTemp;
				$dateend = $datebeginTemp;
			}
			
		}else{
			$datebegin = new \DateTime();
			$result = $datebegin->format('Y-m-d');
			$datebegin = new \DateTime($result);
			$datebegin = $datebegin->modify('first day of this month');
			
			$result = $datebegin->format('Y-m-d');
			$daysInMonth = date("t", strtotime($result))-1;
			$month = date("F", strtotime($result));
			$interval = new \DateInterval('P'.$daysInMonth.'D');
			$dateend = clone $datebegin; 
			$dateend = $dateend->add($interval);
		}
		
		$stateTaking = $businessService->getStateTakingBetween($datebegin, $dateend);
		
		/****** deletion old taking under x mn **********/
		$time = 5; // in minute
		$now = new \DateTime();
		$dateSeuil = $now->sub(new \DateInterval('PT'.$time.'M'));
		$takingsForDeletion = $takingRepository->getTakingsBefore($dateSeuil);
		
		foreach($takingsForDeletion as $takingTemp){
			//echo $takingTemp->getDate()->format('Y-m-d H:i:s')."<br>";
			if(!$takingTemp->getState()){
				$takinglinesTemp = $takinglineRepository->findBy(array(
					'taking' => $takingTemp,
				));
				foreach($takinglinesTemp as $takingline){
					$em->remove($takingline);
				}
				$em->remove($takingTemp);
			}
		}
		
		$em->flush();
		
		/*** construction defined interval ***/
		//yesterday
		$dateendYesterday = new \DateTime();
		$result = $dateendYesterday->format('Y-m-d');
		$day = 1;
		$interval = new \DateInterval('P'.$day.'D');
		$dateendYesterday = $dateendYesterday->sub($interval);
		$datebeginYesterday = $dateendYesterday;
		
		//now
		$dateendNow = new \DateTime();
		$result = $dateendNow->format('Y-m-d');
		$datebeginNow = new \DateTime($result);
		$datebeginNow = $dateendNow;
		
		//this month
		$datebeginThisMonth = new \DateTime();
		$result = $datebeginThisMonth->format('Y-m-d');
		$datebeginThisMonth = new \DateTime($result);
		$datebeginThisMonth = $datebeginThisMonth->modify('first day of this month');
		
		$result = $datebeginThisMonth->format('Y-m-d');
		$daysInMonth = date("t", strtotime($result))-1;
		$interval = new \DateInterval('P'.$daysInMonth.'D');
		$dateendThisMonth = clone $datebeginThisMonth; 
		$dateendThisMonth = $dateendThisMonth->add($interval);
		
		//this year
		$datebeginThisYear = new \DateTime();
		$result = $datebeginThisYear->format('Y-m-d');
		$datebeginThisYear = new \DateTime($result);
		$datebeginThisYear = $datebeginThisYear->modify('first day of January '.date('Y'));
		
		$result = $datebeginThisYear->format('Y');
		$daysInYear = date("z", mktime(0,0,0,12,31,$result));
		$interval = new \DateInterval('P'.$daysInYear.'D');
		$dateendThisYear = clone $datebeginThisYear; 
		$dateendThisYear = $dateendThisYear->add($interval);
		
		//this last 7 days
		$dateend7days = new \DateTime();
		$result = $dateend7days->format('Y-m-d');
		$dateend7days = new \DateTime($result);
		
		$result = $dateend7days->format('Y-m-d');
		$days = 7;
		$interval = new \DateInterval('P'.$days.'D');
		$datebegin7days = clone $dateend7days;
		$datebegin7days = $datebegin7days->sub($interval);
		
		//this last 30 days
		$dateend30days = new \DateTime();
		$result = $dateend30days->format('Y-m-d');
		$dateend30days = new \DateTime($result);
		
		$result = $dateend30days->format('Y-m-d');
		$days = 30;
		$interval = new \DateInterval('P'.$days.'D');
		$datebegin30days = clone $dateend30days;
		$datebegin30days = $datebegin30days->sub($interval);
		
		//this last 365 days
		$dateend365days = new \DateTime();
		$result = $dateend365days->format('Y-m-d');
		$dateend365days = new \DateTime($result);
		
		$result = $dateend365days->format('Y-m-d');
		$days = 365;
		$interval = new \DateInterval('P'.$days.'D');
		$datebegin365days = clone $dateend365days;
		$datebegin365days = $datebegin365days->sub($interval);
		
		$data = array(
			'datebegin365days' => $datebegin365days,
			'dateend365days' => $dateend365days,
			'datebegin30days' => $datebegin30days,
			'dateend30days' => $dateend30days,
			'datebegin7days' => $datebegin7days,
			'dateend7days' => $dateend7days,
			'datebeginThisYear' => $datebeginThisYear,
			'dateendThisYear' => $dateendThisYear,
			'datebeginThisMonth' => $datebeginThisMonth,
			'dateendThisMonth' => $dateendThisMonth,
			'datebeginNow' => $datebeginNow,
			'dateendNow' => $dateendNow,
			'datebeginYesterday' => $datebeginYesterday,
			'dateendYesterday' => $dateendYesterday,
			'profit' => $stateTaking['profit'],
			'amountIn' => $stateTaking['amountIn'],
			'amountOut' => $stateTaking['amountOut'],
			'datebegin' => $datebegin,
			'dateend' => $dateend,
			'taking' => $stateTaking['taking'],
			'takinglines' => $stateTaking['takinglines'],
			'treeview' => 'taking',
			'time' => time(),
		);
		
        return $this->render('COMPlatformBundle:taking:index.html.twig', $data);
    }
	
    public function generatePdfAction($taking_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$takingRepository = $em->getRepository('COMPlatformBundle:Taking');
		$takinglineRepository = $em->getRepository('COMPlatformBundle:Takingline');
		
		$taking = $takingRepository->find($taking_id);
		$takinglines = $takinglineRepository->findBy($data = array(
			'taking' => $taking,
		));

		$data = array(
			'taking' => $taking,
			'takinglines' => $takinglines,
		);

        $template = $this->renderView('COMPlatformBundle:taking:generate-pdf.html.twig', $data);
		
		$html2pdf = $this->get('html2pdf_factory')->create();
		$html2pdf->writeHTML($template);
		
		return $html2pdf->Output(time().'_'.$taking->getId().'.pdf');
    }
}
