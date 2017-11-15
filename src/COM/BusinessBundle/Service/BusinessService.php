<?php

namespace COM\BusinessBundle\Service;

use Doctrine\ORM\EntityManager;
use COM\BusinessBundle\Entity\Product;

use COM\PlatformBundle\Entity\Taking;
use COM\PlatformBundle\Entity\Takingline;

class BusinessService {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getProductimage(Product $product) {
        $productimageRepository = $this->em->getRepository('COMBusinessBundle:Productimage');

        $productimage = $productimageRepository->findOneBy(array(
            'product' => $product,
            'current' => true,
        ));

        if($productimage){
            //return $logo->getPath();
            return $productimage->getWebPath();
        }
        else{
            return 'default/image/product/default.png';
        }
    }
    
    public function getQteStock(Product $product) {
		$stockRepository = $this->em->getRepository('COMBusinessBundle:Stock');
		
		$stocks = $stockRepository->findBy(array(
			'product' => $product,
			'deleted' => false,
		));
        $qteStock = 0;
		foreach ($stocks as $stock) {
			switch ($stock->getType()) {
				case 0:
					$qteStock += $stock->getQuantity();
					break;
				case 1:
					$qteStock -= $stock->getQuantity();
					break;
			}
		}
		
		return $qteStock;
    }
    
    public function getStateStock() {
		$productRepository = $this->em->getRepository('COMBusinessBundle:Product');
		$stockRepository = $this->em->getRepository('COMBusinessBundle:Stock');
		
        $qteStockin = 0;
        $qteStockout = 0;
        $priceStockin = 0;
        $priceStockout = 0;
		
		$products = $productRepository->findBy(array(
			'deleted' => false,
		));
		
		foreach ($products as $product) {
			$stocks = $stockRepository->findBy(array(
				'product' => $product,
				'deleted' => false,
			));
			foreach ($stocks as $stock) {
				switch ($stock->getType()) {
					case 0:
						$qteStockin += $stock->getQuantity();
						$priceStockin += $stock->getQuantity() * $stock->getPrice();
						break;
					case 1:
						$qteStockout += $stock->getQuantity();
						$priceStockout += $stock->getQuantity() * $stock->getPrice();
						break;
				}
			}
		}
		
		$data = array(
			'qteStockin' => $qteStockin,
			'qteStockout' => $qteStockout,
			'priceStockin' => $priceStockin,
			'priceStockout' => $priceStockout,
		);
		
		return $data;
    }
    
    public function getStateTakingBetween($datebegin, $dateend) {
		$transactionRepository = $this->em->getRepository('COMBusinessBundle:Transaction');
		$stockRepository = $this->em->getRepository('COMBusinessBundle:Stock');
		$gainRepository = $this->em->getRepository('COMBusinessBundle:Gain');
		$expenditureRepository = $this->em->getRepository('COMBusinessBundle:Expenditure');
		$takingRepository = $this->em->getRepository('COMPlatformBundle:Taking');
		$takinglineRepository = $this->em->getRepository('COMPlatformBundle:Takingline');
		
		$courseRepository = $this->em->getRepository('COMTrainingBundle:Course');
		$groupRepository = $this->em->getRepository('COMTrainingBundle:Group');
		$studentgroupRepository = $this->em->getRepository('COMTrainingBundle:Studentgroup');
		$feeRepository = $this->em->getRepository('COMTrainingBundle:Fee');
		
		//$platformService = $this->container->get('com_platform.platform_service');
		
		$taking = new Taking();
		$taking->setDate(new \DateTime());
		$taking->setDatebegin($datebegin);
		$taking->setDateend($dateend);
		$taking->setState(false);
		$this->em->persist($taking);
		
		//Stocks - product mouvement
		$stocks = $stockRepository->getStocksBetween($datebegin, $dateend);
		
		foreach($stocks as $stock){
			$takingline = new Takingline();
			$takingline->setDate($stock->getDate());
			
			switch ($stock->getType()) {
				case 0:
					$typeStock = "Entrée en stock";
					$ponderence = -1;
					break;
				case 1:
					$typeStock = "Vente";
					$ponderence = +1;
					break;
			}
			
			$takingline->setAmount($ponderence * $stock->getPrice());
			$takingline->setQuantity($stock->getQuantity());

			$takingline->setName("Mouvement article (".$typeStock.") ".$stock->getProduct()->getName());
			$takingline->setDescription($stock->getDescription());
			$takingline->setEntity('stock');
			$takingline->setEntityid($stock->getId());
			$takingline->setTaking($taking);
			$this->em->persist($takingline);
		}
		
		//gains
		$gains = $gainRepository->getGainsBetween($datebegin, $dateend);
		
		foreach($gains as $gain){
			$takingline = new Takingline();
			$takingline->setDate($gain->getDate());
			$ponderence = +1;
			
			$takingline->setAmount($ponderence * $gain->getAmount());
			$takingline->setQuantity(1);

			$takingline->setName("Gain : ".$gain->getName());
			$takingline->setDescription($gain->getDescription());
			$takingline->setEntity('gain');
			$takingline->setEntityid($gain->getId());
			$takingline->setTaking($taking);
			$this->em->persist($takingline);
		}
		
		//Expenditures
		$expenditures = $expenditureRepository->getExpendituresBetween($datebegin, $dateend);
		
		foreach($expenditures as $expenditure){
			$takingline = new Takingline();
			$takingline->setDate($expenditure->getDate());
			$ponderence = -1;
			
			$takingline->setAmount($ponderence * $expenditure->getAmount());
			$takingline->setQuantity(1);

			$takingline->setName("Dépense : ".$expenditure->getName());
			$takingline->setDescription($expenditure->getDescription());
			$takingline->setEntity('expenditure');
			$takingline->setEntityid($expenditure->getId());
			$takingline->setTaking($taking);
			$this->em->persist($takingline);
		}
		
		//Fees payments
		$courses = $courseRepository->findBy(array(
			'deleted' => false,
		));
		foreach($courses as $course){
			$groups = $groupRepository->findBy(array(
				'course' => $course,
				'deleted' => false,
			));
			foreach($groups as $group){
				$studentgroups = $studentgroupRepository->findBy(array(
					'group' => $group,
					'deleted' => false,
				));
				foreach($studentgroups as $studentgroup){
					$fees = $feeRepository->getFeesByStudentgroupBetween($studentgroup,$datebegin, $dateend);
					foreach($fees as $fee){
						$takingline = new Takingline();
						$takingline->setDate($fee->getPaymentdate());
						$ponderence = +1;
						
						$takingline->setAmount($ponderence * $fee->getAmount());
						$takingline->setQuantity(1);

						$takingline->setName("Règlement frais de cours : ".$studentgroup->getStudent()->getPerson()->getName(). " ".$studentgroup->getStudent()->getPerson()->getFirstname());
						$takingline->setDescription($fee->getDescription());
						$takingline->setEntity('fee');
						$takingline->setEntityid($fee->getId());
						$takingline->setTaking($taking);
						$this->em->persist($takingline);
					}
				}
			}
		}
		
		$this->em->flush();
		
		//recuperation of the current query
		$takinglines = $takinglineRepository->findBy(array(
			'taking' => $taking,
		));
		
		$amountIn = 0;
		$amountOut = 0;
		$profit = 0;
		foreach($takinglines as $takingline){
			$amount = $takingline->getAmount() * $takingline->getQuantity();
			$profit += $amount;
			if($amount > 0){
				$amountIn += $amount;
			}else{
				$amountOut += $amount;
			}
		}
		
		$data = array(
			'profit' => $profit,
			'amountIn' => $amountIn,
			'amountOut' => $amountOut,
			'datebegin' => $datebegin,
			'dateend' => $dateend,
			'taking' => $taking,
			'takinglines' => $takinglines
		);
		
		return $data;
    }
}