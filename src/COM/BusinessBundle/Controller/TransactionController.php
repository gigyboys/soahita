<?php

namespace COM\BusinessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\BusinessBundle\Entity\Product;
use COM\BusinessBundle\Form\Type\ProductInit;
use COM\BusinessBundle\Form\Type\ProductInitType;

use COM\BusinessBundle\Entity\Transaction;
use COM\BusinessBundle\Form\Type\TransactionInit;
use COM\BusinessBundle\Form\Type\TransactionInitType;

class TransactionController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$transactionRepository = $em->getRepository('COMBusinessBundle:Transaction');
		
		$transactions = $transactionRepository->findBy(array(
			'deleted' => false,
		));
		
		$sumCredit = 0;
		$sumDebit = 0;
		
		foreach($transactions as $transaction){
			switch ($transaction->getTransactionType()->getId()) {
				case 1:
					$sumCredit += $transaction->getAmount();
					break;
				case 2:
					$sumDebit += $transaction->getAmount();
					break;
			}
		}
		
		$data = array(
			'transactions' => $transactions,
			'sumCredit' => $sumCredit,
			'sumDebit' => $sumDebit,
			'treeview' => 'business',
			'treeviewmenu' => 'transaction',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMBusinessBundle:transaction:index.html.twig', $data);
    }
	
    public function addTransactionAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$transactionTypeRepository = $em->getRepository('COMBusinessBundle:TransactionType');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$transactionInit = new TransactionInit();
		$formInitTransaction = $this->get('form.factory')->create(TransactionInitType::class, $transactionInit);
		
		if ($formInitTransaction->handleRequest($request)->isValid()) {
			
			$transaction = new Transaction();
			$transaction->setDescription($transactionInit->getDescription());
			$transaction->setAmount($transactionInit->getAmount());
			$transaction->setDeleted(false);
			
			$transactionType = $transactionTypeRepository->find($transactionInit->getTransactionTypeId());
			$transaction->setTransactionType($transactionType);
			
			$date = $platformService->getDate($transactionInit->getDate());
			if($date){
				$transaction->setDate($date);
			}else{
				$transaction->setDate(new \DateTime());
			}

			$em->persist($transaction);
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout de la transaction est fait avec succès.",
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_transaction');
			return new RedirectResponse($url);
		}
		
		$transactionTypes = $transactionTypeRepository->findAll();
		
        return $this->render('COMBusinessBundle:transaction:add-transaction.html.twig', array(
			'transactionTypes' => $transactionTypes,
			'form' => $formInitTransaction->createView(),
			'treeview' => 'business',
			'treeviewmenu' => 'transaction',
		));
    }
	
    public function viewTransactionAction($transaction_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$transactionRepository = $em->getRepository('COMBusinessBundle:Transaction');
		
		$transaction = $transactionRepository->find($transaction_id);
		$session = $request->getSession();
	
		if($transaction){
			$data = array(
				'transaction' => $transaction,
				'treeview' => 'business',
				'treeviewmenu' => 'transaction',
			);
			
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMBusinessBundle:transaction:view-transaction.html.twig', $data);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une transaction qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_transaction');
			return new RedirectResponse($url);
		}
    }
	
    public function editTransactionAction($transaction_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$transactionRepository = $em->getRepository('COMBusinessBundle:Transaction');
		$transactionTypeRepository = $em->getRepository('COMBusinessBundle:TransactionType');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$transactionInit = new TransactionInit();
		$transaction = $transactionRepository->find($transaction_id);
		$session = $request->getSession();
		
		if($transaction){
			$transactionInit->setTransactionTypeId($transaction->getTransactionType()->getId());
			$transactionInit->setDate($transaction->getDate());
			$transactionInit->setAmount($transaction->getAmount());
			$transactionInit->setDescription($transaction->getDescription());
			
			$formInitTransaction = $this->get('form.factory')->create(TransactionInitType::class, $transactionInit);
			
			if ($formInitTransaction->handleRequest($request)->isValid()) {
				
				$transaction->setDescription($transactionInit->getDescription());
				$transaction->setAmount($transactionInit->getAmount());
				$transaction->setDeleted(false);
				
				$transactionType = $transactionTypeRepository->find($transactionInit->getTransactionTypeId());
				$transaction->setTransactionType($transactionType);
				
				$date = $platformService->getDate($transactionInit->getDate());
				if($date){
					$transaction->setDate($date);
				}else{
					$transaction->setDate(new \DateTime());
				}

				$em->persist($transaction);
				$em->flush();
				
				$dataTooltip = array(
					'message' => "La modification sur la transaction est faite avec succès.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_view_transaction', array(
					'transaction_id' => $transaction->getId(),
				));
				return new RedirectResponse($url);
			}
			
			$transactionTypes = $transactionTypeRepository->findAll();
			
			return $this->render('COMBusinessBundle:transaction:edit-transaction.html.twig', array(
				'transaction' => $transaction,
				'transactionInit' => $transactionInit,
				'transactionTypes' => $transactionTypes,
				'form' => $formInitTransaction->createView(),
				'treeview' => 'business',
				'treeviewmenu' => 'transaction',
			));
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une transaction qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_transaction');
			return new RedirectResponse($url);
		}
    }
	
    public function  deleteTransactionAction($transaction_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$transactionRepository = $em->getRepository('COMBusinessBundle:Transaction');
		
		$transaction = $transactionRepository->find($transaction_id);
		$session = $request->getSession();
		
		if($transaction){
			$transaction->setDeleted(true);
			$em->flush();
				
			$dataTooltip = array(
				'message' => "La suppression de la transaction est faite avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_transaction');
			return new RedirectResponse($url);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une transaction qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_transaction');
			return new RedirectResponse($url);
		}
    }
}
