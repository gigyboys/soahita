<?php

namespace COM\PlatformBundle\Twig;

use COM\PlatformBundle\Service\PlatformService;
use COM\PlatformBundle\Entity\Person;

class PlatformExtension extends \Twig_Extension {

    protected $platformService;

    public function __construct(PlatformService $platformService) {
        $this->platformService = $platformService;
    }

    public function getFunctions() {
        return array(
            'getPersonimage' => new \Twig_Function_Method($this, 'getPersonimageFunction'),
            'substrSpace' => new \Twig_Function_Method($this, 'substrSpaceFunction'),
            'formatAmount' => new \Twig_Function_Method($this, 'formatAmountFunction'),
        );
    }

    public function getPersonimageFunction(Person $person) {
        return $this->platformService->getPersonimage($person);
    }

    public function substrSpaceFunction($string, $length) {
        return $this->platformService->substrSpace($string, $length);
    }

    public function formatAmountFunction($amount) {
        return $this->platformService->formatAmount($amount);
    }

    public function getName() {
            return 'platform_extension';
    }

}