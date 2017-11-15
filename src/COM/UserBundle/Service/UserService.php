<?php

namespace COM\UserBundle\Service;

use Doctrine\ORM\EntityManager;
use COM\UserBundle\Entity\User;

class UserService{

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getUserById($id) {
        $userRepository = $this->em->getRepository('COMUserBundle:User');

        $user = $userRepository->findOneBy(array(
            'id' => $id,
        ));
        
		return $user;
    }
    
    public function getUserByUsername($username) {
        $userRepository = $this->em->getRepository('COMUserBundle:User');

        $user = $userRepository->findOneBy(array(
            'username' => $username,
        ));
        
		return $user;
    }
    
    public function getUserByEmail($email) {
        $userRepository = $this->em->getRepository('COMUserBundle:User');

        $user = $userRepository->findOneBy(array(
            'email' => $email,
        ));
        
		return $user;
    }
    
    public function checkHasDoublon($username, $userid) {
        $userRepository = $this->em->getRepository('COMUserBundle:User');

        $user = $userRepository->findOneBy(array(
            'username' => $username,
        ));
		if($user && $user->getId() != $userid){
			return true;
        }else{
			return false;
		}
    }
    
    public function checkHasEmailDoublon($email, $userid) {
        $userRepository = $this->em->getRepository('COMUserBundle:User');

        $user = $userRepository->findOneBy(array(
            'email' => $email,
        ));
		if($user && $user->getId() != $userid){
			return true;
        }else{
			return false;
		}
    }
    
    public function getLinkUserInfo(User $user, $label) {
        $content = $this->container->get('templating')->render('COMUserBundle:user:link-user-info.html.twig', array(
		  'user' => $user,
		  'label' => $label,
		));
		return $content;
    }
}