<?php

namespace COM\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$transactionRepository = $em->getRepository('COMBusinessBundle:Transaction');
		$employeeRepository = $em->getRepository('COMStaffBundle:Employee');
		$studentgroupRepository = $em->getRepository('COMTrainingBundle:Studentgroup');
		$businessService = $this->container->get('com_business.business_service');
		$staffService = $this->container->get('com_staff.staff_service');
		$trainingService = $this->container->get('com_training.training_service');
		
		$transactions = $transactionRepository->findBy(array(
			'deleted' => false,
		));
		
		$sumCredit = 0;
		$sumDebit = 0;
		$sum = 0;
		
		foreach($transactions as $transaction){
			$sum += $transaction->getAmount();
			switch ($transaction->getTransactionType()->getId()) {
				case 1:
					$sumCredit += $transaction->getAmount();
					break;
				case 2:
					$sumDebit += $transaction->getAmount();
					break;
			}
		}
		
		//transaction
		$transactions = array();
		$transaction = array(
			'value'    => $sumCredit,
			'percentage'    => $sumCredit * 100 / $sum,
			'color'    => '#3c8d16',
			'highlight'=> '#3c8d16',
			'label'    => 'Crédit'
		);
		array_push($transactions,$transaction);
		$transaction = array(
			'value'    => $sumDebit,
			'percentage'    => $sumDebit * 100 / $sum,
			'color'    => '#d21416',
			'highlight'=> '#d21416',
			'label'    => 'Débit'
		);
		array_push($transactions,$transaction);
		
		//chart monthly
		$months = 12;
		
		$labels = array();
		$dataPayment = array();
		$dataWithdrawal = array();
		$datebegin = new \DateTime();
		
		for ($i = 1; $i<=$months ; $i++) {
			$result = $datebegin->format('Y-m-d');
			$datebegin = new \DateTime($result);
			$datebegin = $datebegin->modify('first day of this month');
			$result = $datebegin->format('Y-m-d');
			$daysInMonth = date("t", strtotime($result))-1;
			//$month = date("F", strtotime($result));
			$month = date("n", strtotime($result));
			
			$monthLabels = array(
				'1' => 'Janvier',
				'2' => 'Février',
				'3' => 'Mars',
				'4' => 'Avril',
				'5' => 'Mey',
				'6' => 'Juin',
				'7' => 'Juillet',
				'8' => 'Août',
				'9' => 'Septembre',
				'10' => 'Octobre',
				'11' => 'Novembre',
				'12' => 'Décembre',
			);
			
			$interval = new \DateInterval('P'.$daysInMonth.'D');
			$dateend = clone $datebegin; 
			$dateend = $dateend->add($interval);
			
			$transactionsMonthly = $transactionRepository->getTransactionsBetween($datebegin, $dateend);
			
			$payment = 0;
			$withdrawal = 0;
			foreach($transactionsMonthly as $transaction){
				if($transaction->getTransactionType()->getId() == 1){
					$payment += $transaction->getAmount();
				}elseif($transaction->getTransactionType()->getId() == 2){
					$withdrawal += $transaction->getAmount();
				}
			}
			$labels[] = $monthLabels[$month];
			$dataPayment[] = $payment;
			$dataWithdrawal[] = $withdrawal;
			
			$datebegin = $datebegin->sub(new \DateInterval('P15D'));
		}
		
		$labels = array_reverse($labels);
		$dataPayment = array_reverse($dataPayment);
		$dataWithdrawal = array_reverse($dataWithdrawal);
		
		//$labels = array('January', 'February');
		//$dataPayment = array(20000, 10000);
		//$dataWithdrawal = array(10000, 25022);
		
		$datasetWithdrawal = array(
			'label'               => 'Versement',
			'fillColor'          => 'rgb(210, 20, 22)',
			'strokeColor'         => 'rgb(210, 20, 22)',
			'pointColor'          => 'rgb(210, 20, 22)',
			'pointStrokeColor'    => 'rgb(210, 20, 22)',
			'pointHighlightFill'  => '#fff',
			'pointHighlightStroke'=> 'rgb(210,20,22)',
			'data'                => $dataWithdrawal
		);
		$datasetPayment = array(
			'label'               => 'Retrait',
			'fillColor'          => 'rgba(60,141,22,0.9)',
			'strokeColor'         => 'rgba(60,141,22,0.8)',
			'pointColor'          => 'rgba(60,141,22,1)',
			'pointStrokeColor'    => 'rgba(60,141,22,1)',
			'pointHighlightFill'  => '#fff',
			'pointHighlightStroke'=> 'rgba(60,141,22,1)',
			'data'                => $dataPayment 
		);
		$datasets = array($datasetWithdrawal, $datasetPayment);
		$transactionsMonthly = array(
			'labels' => $labels, 
			'datasets' => $datasets, 
		);
		
		//etat stock
		$stateStock = $businessService->getStateStock();
		
		//absences
		$absences = 0;
		$employees = $employeeRepository->findBy(array(
			'deleted' => false,
		));
		foreach($employees as $employee){
			if(!$staffService->isPresent($employee)) {
				$absences++;
			}
		}
		
		//reglements
		$reglements = 0;
		$studentgroups = $studentgroupRepository->findBy(array(
			'deleted' => false,
		));
		foreach($studentgroups as $studentgroup){
			$sumFee = $trainingService->getSumFee($studentgroup);
			if($studentgroup->getPrice() > $sumFee){
				$reglements++;
			}
		}
		
		$data = array(
			'transactionsMonthly' => $transactionsMonthly,
			'transactions' => $transactions,
			'stateStock' => $stateStock,
			'absences' => $absences,
			'reglements' => $reglements,
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMPlatformBundle:dashboard:index.html.twig', $data);
    }
}
