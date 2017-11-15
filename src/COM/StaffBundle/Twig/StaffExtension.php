<?php

namespace COM\StaffBundle\Twig;

use COM\StaffBundle\Service\StaffService;
use COM\StaffBundle\Entity\Employee;
use COM\StaffBundle\Entity\Absence;

class StaffExtension extends \Twig_Extension {

    protected $staffService;

    public function __construct(StaffService $staffService) {
        $this->staffService = $staffService;
    }

    public function getFunctions() {
        return array(
            'isPresent' => new \Twig_Function_Method($this, 'isPresentFunction'),
        );
    }

    public function isPresentFunction(Employee $employee) {
        return $this->staffService->isPresent($employee);
    }

    public function getName() {
            return 'staff_extension';
    }

}