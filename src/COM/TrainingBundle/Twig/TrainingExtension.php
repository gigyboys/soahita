<?php

namespace COM\TrainingBundle\Twig;

use COM\TrainingBundle\Service\TrainingService;
use COM\TrainingBundle\Entity\Fee;
use COM\TrainingBundle\Entity\Student;
use COM\TrainingBundle\Entity\Studentgroup;

class TrainingExtension extends \Twig_Extension {

    protected $trainingService;

    public function __construct(TrainingService $trainingService) {
        $this->trainingService = $trainingService;
    }

    public function getFunctions() {
        return array(
            'getSumFee' => new \Twig_Function_Method($this, 'getSumFeeFunction'),
            'getSumRestFee' => new \Twig_Function_Method($this, 'getSumRestFeeFunction'),
        );
    }

    public function getSumFeeFunction(Studentgroup $studentgroup) {
        return $this->trainingService->getSumFee($studentgroup);
    }

    public function getSumRestFeeFunction(Student $student) {
        return $this->trainingService->getSumRestFee($student);
    }

    public function getName() {
            return 'training_extension';
    }

}