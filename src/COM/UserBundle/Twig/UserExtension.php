<?php

namespace COM\UserBundle\Twig;

use COM\UserBundle\Service\UserService;
use COM\UserBundle\Entity\User;

class UserExtension extends \Twig_Extension {

    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getFunctions() {
        return array(
            'getUserById' => new \Twig_Function_Method($this, 'getUserByIdFunction'),
            'getUserByUsername' => new \Twig_Function_Method($this, 'getUserByUsernameFunction'),
            'getUserByEmail' => new \Twig_Function_Method($this, 'getUserByEmailFunction'),
            'getLinkUserInfo' => new \Twig_Function_Method($this, 'getLinkUserInfoFunction'),
        );
    }

    public function getUserByIdFunction($id) {
        return $this->userService->getUserById($id);
    }

    public function getUserByUsernameFunction($username) {
        return $this->userService->getUserByUsername($username);
    }

    public function getUserByEmailFunction($email) {
        return $this->userService->getUserByEmail($email);
    }

    public function getLinkUserInfoFunction(User $user, $label) {
        return $this->userService->getLinkUserInfo($user, $label);
    }

    public function getName() {
            return 'user_extension';
    }

}