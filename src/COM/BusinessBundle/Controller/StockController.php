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

use COM\BusinessBundle\Entity\Stock;
use COM\BusinessBundle\Form\Type\StockInit;
use COM\BusinessBundle\Form\Type\StockInitType;

class StockController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$stockRepository = $em->getRepository('COMBusinessBundle:Stock');
		
		$stocks = $stockRepository->findBy(array(
			'deleted' => false,
		));
		$stockins = $stockRepository->findBy(array(
			'deleted' => false,
			'type' => false,
		));
		$stockouts = $stockRepository->findBy(array(
			'deleted' => false,
			'type' => true,
		));
		
		
		$data = array(
			'stocks' => $stocks,
			'stockins' => $stockins,
			'stockouts' => $stockouts,
			'treeview' => 'business',
			'treeviewmenu' => 'stock',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMBusinessBundle:stock:index.html.twig', $data);
    }
	
    public function addStockAction($type, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		$platformService = $this->container->get('com_platform.platform_service');
		$businessService = $this->container->get('com_business.business_service');
		
		$stockInit = new StockInit();
		$formInitStock = $this->get('form.factory')->create(StockInitType::class, $stockInit);
		
		if ($formInitStock->handleRequest($request)->isValid()) {
			
			$stock = new Stock();
			$stock->setPrice($stockInit->getPrice());
			$stock->setQuantity($stockInit->getQuantity());
			$stock->setDescription($stockInit->getDescription());
			$stock->setDeleted(false);
			
			switch ($type) {
				case 'in':
					$typeValue = false;
					break;
				case 'out':
					$typeValue = true;
					break;
			}
			$stock->setType($typeValue);
			
			$product = $productRepository->find($stockInit->getProductId());
			$stock->setProduct($product);
			
			$date = $platformService->getDate($stockInit->getDate());
			if($date){
				$stock->setDate($date);
			}else{
				$stock->setDate(new \DateTime());
			}

			$em->persist($stock);
			$em->flush();
			
			switch ($type) {
				case 'in':
					$message = "L'ajout dans la liste de stock de l'article &quot;".$product->getName()."&quot; est fait avec succès";
					break;
				case 'out':
					$message = "L'ajout dans la liste de vente de l'article &quot;".$product->getName()."&quot; est fait avec succès";
					break;
			}
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => $message,
			);
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_stock');
			return new RedirectResponse($url);
		}
		
		$productTemps = $productRepository->findBy(array(
			'deleted' => false,
		));
		
		$products = array();
		foreach ($productTemps as $productTemp) {
			$qteStock = $businessService->getQteStock($productTemp);
			array_push($products,array(
				'id' => $productTemp->getId(),
				'name' => $productTemp->getName(),
				'qteStock' => $qteStock,
			));
		}
		
		switch ($type) {
			case 'in':
				$view = 'COMBusinessBundle:stock:add-stock-in.html.twig';
				break;
			case 'out':
				$view = 'COMBusinessBundle:stock:add-stock-out.html.twig';
				break;
		}
        return $this->render($view, array(
			'products' => $products,
			'type' => $type,
			'form' => $formInitStock,
			'treeview' => 'business',
			'treeviewmenu' => 'stock',
		));
    }
	
    public function viewStockAction($stock_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$stockRepository = $em->getRepository('COMBusinessBundle:Stock');
		
		$stock = $stockRepository->find($stock_id);
		$session = $request->getSession();
	
		if($stock){
			$data = array(
				'stock' => $stock,
				'treeview' => 'business',
				'treeviewmenu' => 'stock',
			);
			
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			return $this->render('COMBusinessBundle:stock:view-stock.html.twig', $data);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une ligne stock qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_stock');
			return new RedirectResponse($url);
		}
    }
	
    public function editStockAction($stock_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$stockRepository = $em->getRepository('COMBusinessBundle:Stock');
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$stockInit = new StockInit();
		$stock = $stockRepository->find($stock_id);
		$session = $request->getSession();
		
		if($stock){
			$stockInit->setProductId($stock->getProduct()->getId());
			$stockInit->setDate($stock->getDate());
			$stockInit->setPrice($stock->getPrice());
			$stockInit->setQuantity($stock->getQuantity());
			$stockInit->setDescription($stock->getDescription());
			
			$formInitStock = $this->get('form.factory')->create(StockInitType::class, $stockInit);
			
			if ($formInitStock->handleRequest($request)->isValid()) {
				
				$stock->setPrice($stockInit->getPrice());
				$stock->setQuantity($stockInit->getQuantity());
				$stock->setDescription($stockInit->getDescription());
				
				$date = $platformService->getDate($stockInit->getDate());
				if($date){
					$stock->setDate($date);
				}else{
					$stock->setDate(new \DateTime());
				}

				$em->persist($stock);
				$em->flush();
				
				$product=$stock->getProduct();
				switch ($stock->getType()) {
					case '0':
						$message = "Modification sur l'entrée en stock de l'article &quot;".$product->getName()."&quot; faite avec succès";
						break;
					case '1':
						$message = "Modification sur la vente de l'article &quot;".$product->getName()."&quot; est faite avec succès";
						break;
				}
				
				$dataTooltip = array(
					'message' => $message,
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_view_stock', array(
					'stock_id' => $stock->getId(),
				));
				return new RedirectResponse($url);
			}
			
			$productTemps = $productRepository->findBy(array(
				'deleted' => false,
			));

			$view = 'COMBusinessBundle:stock:edit-stock.html.twig';
			return $this->render($view, array(
				'stock' => $stock,
				'stockInit' => $stockInit,
				'form' => $formInitStock,
				'treeview' => 'business',
				'treeviewmenu' => 'stock',
			));
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une ligne stock qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_stock');
			return new RedirectResponse($url);
		}
    }
	
    public function  deleteStockAction($stock_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$stockRepository = $em->getRepository('COMBusinessBundle:Stock');
		
		$stock = $stockRepository->find($stock_id);
		$session = $request->getSession();
		
		if($stock){
			$stock->setDeleted(true);
			$em->flush();
				
			$dataTooltip = array(
				'message' => "La suppression de la ligne stock pour l'article &quot".$stock->getProduct()->getName()."&quot est faite avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_stock');
			return new RedirectResponse($url);
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une ligne stock qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_stock');
			return new RedirectResponse($url);
		}
    }
}
