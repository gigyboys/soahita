<?php

namespace COM\BusinessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\BusinessBundle\Entity\Expenditure;
use COM\BusinessBundle\Form\Type\ExpenditureInit;
use COM\BusinessBundle\Form\Type\ExpenditureInitType;

class ExpenditureController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$expenditureRepository = $em->getRepository('COMBusinessBundle:Expenditure');
		
		$expenditures = $expenditureRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'expenditures' => $expenditures,
			'treeview' => 'business',
			'treeviewmenu' => 'expenditure',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMBusinessBundle:expenditure:index.html.twig', $data);
    }
	
	
    public function addExpenditureAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$expenditureRepository = $em->getRepository('COMBusinessBundle:Expenditure');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$expenditureInit = new ExpenditureInit();
		$formInitExpenditure = $this->get('form.factory')->create(ExpenditureInitType::class, $expenditureInit);
		
		if ($formInitExpenditure->handleRequest($request)->isValid()) {
			
			$expenditure = new Expenditure();
			$expenditure->setName($expenditureInit->getName());
			$expenditure->setAmount($expenditureInit->getAmount());
			$expenditure->setDescription($expenditureInit->getDescription());
			
			$date = $platformService->getDate($expenditureInit->getDate());
			if($date){
				$expenditure->setDate($date);
			}else{
				$expenditure->setDate(new \DateTime());
			}
			
			$expenditure->setDeleted(false);

			$em->persist($expenditure);
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout de la dépense &quot;".$expenditure->getName()."&quot; est fait avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_expenditure');
			return new RedirectResponse($url);
		}

        return $this->render('COMBusinessBundle:expenditure:add-expenditure.html.twig', array(
			'expenditureInit' => $expenditureInit,
			'form' => $formInitExpenditure,
			'treeview' => 'business',
			'treeviewmenu' => 'expenditure',
		));
    }
	
    public function viewExpenditureAction($expenditure_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$expenditureRepository = $em->getRepository('COMBusinessBundle:Expenditure');
		
		$expenditure = $expenditureRepository->find($expenditure_id);
		$session = $request->getSession();
	
		if($expenditure){
			$data = array(
				'expenditure' => $expenditure,
				'treeview' => 'business',
				'treeviewmenu' => 'expenditure',
			);
			
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMBusinessBundle:expenditure:view-expenditure.html.twig', $data);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une dépense qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_expenditure');
			return new RedirectResponse($url);
		}
    }
	
    public function editExpenditureAction($expenditure_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$expenditureRepository = $em->getRepository('COMBusinessBundle:Expenditure');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$expenditureInit = new ExpenditureInit();
		
		$expenditure = $expenditureRepository->find($expenditure_id);
		if($expenditure){
			$expenditureInit->setName($expenditure->getName());
			$expenditureInit->setAmount($expenditure->getAmount());
			$expenditureInit->setDate($expenditure->getDate());
			$expenditureInit->setDescription($expenditure->getDescription());
			
			$formInitExpenditure = $this->get('form.factory')->create(ExpenditureInitType::class, $expenditureInit);
			$session = $request->getSession();
			
			if ($formInitExpenditure->handleRequest($request)->isValid()) {
				
				$expenditure->setName($expenditureInit->getName());
				$expenditure->setAmount($expenditureInit->getAmount());
				$expenditure->setDescription($expenditureInit->getDescription());
				
				$date = $platformService->getDate($expenditureInit->getDate());
				if($date){
					$expenditure->setDate($date);
				}else{
					$expenditure->setDate(new \DateTime());
				}

				$em->persist($expenditure);
				
				$em->flush();
				
				$dataTooltip = array(
					'message' => "L'édition sur la dépense &quot;".$expenditure->getName()."&quot; est faite avec succès.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_view_expenditure', array(
					'expenditure_id' => $expenditure->getId()
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMBusinessBundle:expenditure:edit-expenditure.html.twig', array(
				'expenditure' => $expenditure,
				'expenditureInit' => $expenditureInit,
				'form' => $formInitExpenditure->createView(),
				'treeview' => 'business',
				'treeviewmenu' => 'expenditure',
			));
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une dépense qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_expenditure');
			return new RedirectResponse($url);
		}
    }
	
    public function deleteExpenditureAction($expenditure_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$expenditureRepository = $em->getRepository('COMBusinessBundle:Expenditure');
		
		$expenditure = $expenditureRepository->find($expenditure_id);
		$session = $request->getSession();
		
		if($expenditure){
			$expenditure->setDeleted(true);
			$em->flush();
				
			$dataTooltip = array(
				'message' => "La suppression de la dépense &quot;".$expenditure->getName()."&quot; est faite avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_expenditure');
			return new RedirectResponse($url);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une dépense qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_expenditure');
			return new RedirectResponse($url);
		}
    }
	
}
