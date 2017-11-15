<?php

namespace COM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use COM\UserBundle\Entity\User;
use COM\UserBundle\Form\Type\UserInit;
use COM\UserBundle\Form\Type\UserInitType;
use COM\UserBundle\Form\Type\UserpasswordInit;
use COM\UserBundle\Form\Type\UserpasswordInitType;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('COMUserBundle:user:index.html.twig');
    }
    public function loginAction()
    {
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->redirectToRoute('com_platform_home');
		}

		$authenticationUtils = $this->get('security.authentication_utils');

		return $this->render('COMUserBundle:user:login.html.twig', array(
			'last_username' => $authenticationUtils->getLastUsername(),
			'error'         => $authenticationUtils->getLastAuthenticationError(),
		));
    }
	
    public function setNewPasswordAction($username, $key, Request $request)
    {
		$keyLength = 7;
		$em = $this->getDoctrine()->getManager();
		$userRepository = $em->getRepository('COMUserBundle:User');
		
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->redirectToRoute('com_platform_home');
		}
		
		$user = $userRepository->findOneBy(array(
			'username' => $username,
		));
		
		$authenticationUtils = $this->get('security.authentication_utils');
		
		$now = new \DateTime();
		$plain = $now->format('Y-m-d');
		//echo $plain;
		$plainMD5 = md5($plain);
		$plainMD5 = substr($plainMD5, 0, $keyLength);
		
		if($user && $key == $plainMD5){
			$returnKey = md5(time());
			$returnKey = substr($returnKey, 0, $keyLength);
			
			$newPassword = md5($plain.$username.$returnKey);
			$newPassword = substr($newPassword, 0, $keyLength);
			
			$encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
			$newPasswordEncoded = $encoder->encodePassword($newPassword, $user->getSalt());
			$user->setPassword($newPasswordEncoded);
			$em->persist($user);
			$em->flush();
						
			return $this->render('COMUserBundle:user:login.html.twig', array(
				'last_username' => $authenticationUtils->getLastUsername(),
				'error'         => $authenticationUtils->getLastAuthenticationError(),
				'messageNewPassword' => "mot de passe réinitialisé avec la clé :<br /> ".$returnKey/*." <br />Nouveau mot de passe : <br />".$newPassword*/,
			));
		}else{
			$user = $userRepository->find(1);
			return $this->render('COMUserBundle:user:login.html.twig', array(
				'last_username' => $authenticationUtils->getLastUsername(),
				'error'         => $authenticationUtils->getLastAuthenticationError(),
				'messageNewPassword' => "La réinitialisation du mot de passe n'a pas pu aboutir. Veuillez essayer une autre tentative pour l'utilisateur : ".$user->getUsername(),
			));
		}
		
    }
	
    public function profileAction($username, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$userRepository = $em->getRepository('COMUserBundle:User');
		
		$user = $userRepository->findOneBy(array(
			'username' => $username,
		));
		
		if($user){
			if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') &&  $this->getUser()->getId() == $user->getId()) {
		
				$data = array(
					'user' => $user,
				);
		
				$session = $request->getSession();
				$dataTooltip = $session->get('dataTooltip');
				if($dataTooltip){		
					$data['dataTooltip'] = $dataTooltip;			
					$session->remove('dataTooltip');
				}
				
				return $this->render('COMUserBundle:user:profile.html.twig', $data);
			}else{
				//throw new NotFoundHttpException('Page not found');
				$session = $request->getSession();
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Vous vous tentez à accéder à une page qui n'éxiste pas.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_platform_home');
				return new RedirectResponse($url);
			}
		}else{
			//throw new NotFoundHttpException('Page not found');
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une page qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_platform_home');
			return new RedirectResponse($url);
		}
    }
	
    public function editUserAction($username, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
		$userRepository = $em->getRepository('COMUserBundle:User');
		$platformService = $this->container->get('com_platform.platform_service');
		$userService = $this->container->get('com_user.user_service');
		
		$user = $userRepository->findOneBy(array(
			'username' => $username,
		));
		
		if($user){
			if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') &&  $this->getUser()->getId() == $user->getId()) {
				$person = $user->getPerson();
				
				$userInit = new UserInit();
				$userInit->setName($person->getName());
				$userInit->setFirstname($person->getFirstname());
				$userInit->setSex($person->getSex());
				$userInit->setBirthdate($person->getBirthdate());
				$userInit->setBirthlocation($person->getBirthlocation());
				$userInit->setCin($person->getCin());
				$userInit->setCindate($person->getCindate());
				$userInit->setCinlocation($person->getCinlocation());
				$userInit->setAddress($person->getAddress());
				$userInit->setPhone($person->getPhone());
				$userInit->setEmail($person->getEmail());
				
				$userInit->setUsername($user->getUsername());
				
				$formInitUser = $this->get('form.factory')->create(UserInitType::class, $userInit);
				
				$session = $request->getSession();
				if ($formInitUser->handleRequest($request)->isValid()) {
					
					$hasError = false;
					$errorUsername = false;
					$errors = array();
					
					$person->setName($userInit->getName());
					$person->setFirstname($userInit->getFirstname());
					$person->setSex($userInit->getSex());
					$person->setCin($userInit->getCin());
					
					$date = $platformService->getDate($userInit->getCindate());
					if($date){
						$person->setCindate($date);
					}else{
						$person->setCindate(null);
					}
					
					$person->setCinlocation($userInit->getCinlocation());
					
					$person->setAddress($userInit->getAddress());
					$person->setPhone($userInit->getPhone());
					$person->setEmail($userInit->getEmail());

					$date = $platformService->getDate($userInit->getBirthdate());
					if($date){
						$person->setBirthdate($date);
					}else{
						$person->setBirthdate(null);
					}
					$person->setBirthlocation($userInit->getBirthlocation());

					$em->persist($person);
					
					$username = $platformService->sluggify($userInit->getUsername());
					
					if($username == ""){
						$hasError = true;
						$$errorUsername = true;
						$errors [] = "Vous devez fournir un nom d'utilisateur";
					}

					if(!$errorUsername){
						$hasDoublon = $userService->checkHasDoublon($username, $user->getId());
						if($hasDoublon){
							$hasError = true;
							$$errorUsername = true;
							$errors [] = "Choisissez un autre nom d'utilisateur";	
						}
					}
					

					if(!$hasError){
					
						$user->setUsername($username);
						$em->persist($user);
						$em->flush();
						
						$oldToken = $this->container->get('security.token_storage')->getToken();
						$token = new UsernamePasswordToken(
							$user,
							null,
							$oldToken->getProviderKey(),
							$user->getRoles()
						);
						$this->container->get('security.token_storage')->setToken($token);
						
						$dataTooltip = array(
							'message' => "Modification de l'utilisateur &quot;".$user->getPerson()->getName()." ".$user->getPerson()->getFirstname()."&quot; faite avec succès.",
						);
						$session->set('dataTooltip', $dataTooltip);
						
						$url = $this->get('router')->generate('com_user_profile', array(
							'username' => $user->getUsername(),
						));
						
						return new RedirectResponse($url);
					}else{
						$messageError = "";
						foreach ($errors as $error) {
							$messageError .= " ".$error;
						}
						
						$dataTooltip = array(
							'type' => 'error',
							'message' => "Veuillez bien remplir les champs.".$messageError,
						);
						$session->set('dataTooltip', $dataTooltip);
					}
				}
				
				$data = array(
					'user' => $user,
					'person' => $person,
					'userInit' => $userInit,
					'form' => $formInitUser->createView(),
					/*'treeview' => 'user',
					'treeviewmenu' => 'profile',*/
				);
		
				$dataTooltip = $session->get('dataTooltip');
				if($dataTooltip){		
					$data['dataTooltip'] = $dataTooltip;			
					$session->remove('dataTooltip');
				}
				return $this->render('COMUserBundle:user:edit-user.html.twig', $data);
			}else{
				//throw new NotFoundHttpException('Page not found');
				$session = $request->getSession();
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Vous vous tentez à accéder à une page qui n'éxiste pas.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_platform_home');
				return new RedirectResponse($url);
			}
		}else{
			//throw new NotFoundHttpException('Page not found');
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une page qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_platform_home');
			return new RedirectResponse($url);
		}
    }
	
    public function editUserPasswordAction($username, Request $request)
    {
			$em = $this->getDoctrine()->getManager();
			$personRepository = $em->getRepository('COMPlatformBundle:Person');
			$userRepository = $em->getRepository('COMUserBundle:User');
			$platformService = $this->container->get('com_platform.platform_service');
			$userService = $this->container->get('com_user.user_service');
			
			$user = $userRepository->findOneBy(array(
				'username' => $username,
			));
			
			if($user){
				$userpasswordInit = new UserpasswordInit();
				
				$formInitUserpassword = $this->get('form.factory')->create(UserpasswordInitType::class, $userpasswordInit);
				
				$session = $request->getSession();
				if ($formInitUserpassword->handleRequest($request)->isValid()) {
					//traitement
					$encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
					$currentPasswordEncoded = $encoder->encodePassword($userpasswordInit->getCurrentpassword(), $user->getSalt());
					if($user->getPassword() == $currentPasswordEncoded && $userpasswordInit->getNewpassword() != "" && (string)$userpasswordInit->getNewpassword() === (string)$userpasswordInit->getRepeatedPassword()) {
						$newPasswordEncoded = $encoder->encodePassword($userpasswordInit->getNewpassword(), $user->getSalt());
						$user->setPassword($newPasswordEncoded);
						$em->persist($user);
						$em->flush();
						
						$dataTooltip = array(
							'message' => "Modification de mot de passe faite avec succès.",
						);
						$session->set('dataTooltip', $dataTooltip);
						
						$url = $this->get('router')->generate('com_user_profile', array(
							'username' => $user->getUsername(),
						));
						
						return new RedirectResponse($url);
					} else {
						$messageError = " Une erreur est survenue lors de la modification du mot de passe.";
						/*
						foreach ($errors as $error) {
							$messageError .= " ".$error;
						}
						*/
						$dataTooltip = array(
							'type' => 'error',
							'message' => "Veuillez bien remplir les champs.".$messageError,
						);
						$session->set('dataTooltip', $dataTooltip);
					}
					//fin traitement
				}
				
				
				$data = array(
					'user' => $user,
					'userpasswordInit' => $userpasswordInit,
					'form' => $formInitUserpassword->createView(),
					/*'treeview' => 'user',
					'treeviewmenu' => 'profile',*/
				);
		
				$dataTooltip = $session->get('dataTooltip');
				if($dataTooltip){		
					$data['dataTooltip'] = $dataTooltip;			
					$session->remove('dataTooltip');
				}
				return $this->render('COMUserBundle:user:edit-userpassword.html.twig', $data);
			}else{
				//throw new NotFoundHttpException('Page not found');
				$session = $request->getSession();
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Vous vous tentez à accéder à une page qui n'éxiste pas.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_platform_home');
				return new RedirectResponse($url);
			}
    }
}
