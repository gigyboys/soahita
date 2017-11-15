<?php

namespace COM\BusinessBundle\Twig;

use COM\BusinessBundle\Service\BusinessService;
use COM\BusinessBundle\Entity\Product;

class BusinessExtension extends \Twig_Extension {

    protected $businessService;

    public function __construct(BusinessService $businessService) {
        $this->businessService = $businessService;
    }

    public function getFunctions() {
        return array(
            'getProductimage' => new \Twig_Function_Method($this, 'getProductimageFunction'),
            'getQteStock' => new \Twig_Function_Method($this, 'getQteStockFunction'),
            'getStateTakingBetween' => new \Twig_Function_Method($this, 'getStateTakingBetweenFunction'),
        );
    }

    public function getProductimageFunction(Product $product) {
        return $this->businessService->getProductimage($product);
    }

    public function getQteStockFunction(Product $product) {
        return $this->businessService->getQteStock($product);
    }

    public function getStateTakingBetweenFunction($datebegin, $dateend) {
		//date with format 'Y-m-d'
		$datebegin = new \DateTime($datebegin);
		$dateend = new \DateTime($dateend);
        return $this->businessService->getStateTakingBetween($datebegin, $dateend);
    }

    public function getName() {
            return 'business_extension';
    }

}