<?php

namespace COM\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use COM\PlatformBundle\Entity\Person;

use COM\PlatformBundle\Entity\Personimage;
use COM\PlatformBundle\Form\Type\PersonimageType;

class PersonController extends Controller
{
	public function changeImagePopupAction($person_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
        $personimageRepository = $em->getRepository('COMPlatformBundle:Personimage');
		
		$person = $personRepository->find($person_id);
		$images = $personimageRepository->findBy(array(
			'person' => $person
		));
		$current = $personimageRepository->findOneBy(array(
			'person' => $person,
			'current' => true,
		));
		
        $response = new Response();

		$content = $this->renderView('COMPlatformBundle:platform:change_image_popup.html.twig', array(
			'person' => $person,
			'images' => $images,
			'current' => $current,
		));
			
		$response->setContent(json_encode(array(
			'state' => 1,
			'content' => $content,
		)));
		
        $response->headers->set('Content-Type', 'application/json');
		return $response;
    }

	public function uploadPersonimageAction($person_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
        $personimageRepository = $em->getRepository('COMPlatformBundle:Personimage');
        
        $image = new Personimage();
		$person = $personRepository->find($person_id);
		$userOnline = $this->getUser();
        
		$formImage = $this->get('form.factory')->create(PersonimageType::class, $image);
		
        $formImage->handleRequest($request);
		
        $response = new Response();

		$response->setContent(json_encode(array(
			'state' => 0,
		)));

        if ($formImage->isValid()) {
			
			if($userOnline->getPerson()->getId() == $person->getId()){
				$isUserOnline = true;
			}else{
				$isUserOnline = false;
			}
				
            $images = $personimageRepository->findBy(array(
				'person' => $person
			));
            
            foreach ($images as $imageTemp) {
                $imageTemp->setCurrent(false);
				$em->persist($imageTemp);
            }
			
            $image->setCurrent(true);
            $image->setPerson($person);
			
            $em->persist($image);
            $em->flush();
			
            $image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
			  'path' => $image->getWebPath(),
			  'filter' => '120x120',
			));
			
            $imageItemContent = $this->renderView('COMPlatformBundle:platform:include/personimage_item.html.twig', array(
			  'person' => $person,
			  'image' => $image,
			  'classActive' => 'active'
			));
			
            $response->setContent(json_encode(array(
                'state' => 1,
                'image120x120' => $image120x120,
                'imageItemContent' => $imageItemContent,
				'isUserOnline' => $isUserOnline,
            )));
        }
		
		$response->headers->set('Content-Type', 'application/json');
		return $response;
    }

	public function deletePersonimageAction($person_id, $personimage_id)
    {
        $em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
        $personimageRepository = $em->getRepository('COMPlatformBundle:Personimage');
		
		$person = $personRepository->find($person_id);
		$userOnline = $this->getUser();
		
		$image = $personimageRepository->find($personimage_id);
		
        $response = new Response();
		
		$response->setContent(json_encode(array(
			'state' => 0,
		)));
		
		if($person && $image){
			if($person->getId() == $image->getPerson()->getId()){
				
				if($userOnline->getPerson()->getId() == $person->getId()){
					$isUserOnline = true;
				}else{
					$isUserOnline = false;
				}
				
				$imageId = $image->getId();
				$em->remove($image);
				$em->flush();
				
				$current = $personimageRepository->findOneBy(array(
					'person' => $person,
					'current' => true,
				));
				
				if($current){
					
					$image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
					  'path' => $current->getWebPath(),
					  'filter' => '120x120',
					));
					
					$response->setContent(json_encode(array(
						'state' => 1,
						'imageId' => $imageId,
						'image120x120' => $image120x120,
						'isCurrent' => false,
					)));
				}else{
				
					if($person->getSex() == '0'){
						$defaultImagePath = 'default/image/person/defaultman.png';
					}elseif($person->getSex() == '1'){
						$defaultImagePath = 'default/image/person/defaultwoman.png';
					}else{
						$defaultImagePath = 'default/image/person/default.png';
					}
					
					$image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
					  'path' => $defaultImagePath,
					  'filter' => '120x120',
					));
					
					$response->setContent(json_encode(array(
						'state' => 1,
						'imageId' => $imageId,
						'image120x120' => $image120x120,
						'isCurrent' => true,
						'isUserOnline' => $isUserOnline,
					)));
				}
			}
		}
		
        $response->headers->set('Content-Type', 'application/json');
		return $response;
    }

	public function selectPersonimageAction($person_id, $personimage_id)
    {
        $em = $this->getDoctrine()->getManager();
		$personRepository = $em->getRepository('COMPlatformBundle:Person');
        $personimageRepository = $em->getRepository('COMPlatformBundle:Personimage');
		
		$person = $personRepository->find($person_id);
		
		$userOnline = $this->getUser();
		$response = new Response();
		
		$response->setContent(json_encode(array(
			'state' => 0,
		)));
		
		if($person){
			
			if($userOnline->getPerson()->getId() == $person->getId()){
				$isUserOnline = true;
			}else{
				$isUserOnline = false;
			}
			
			if($personimage_id == 0){
				$images = $personimageRepository->findBy(array(
					'person' => $person
				));

				foreach ($images as $image) {
					$image->setCurrent(false);
					$em->persist($image);
				}
				$em->flush();
				
				if($person->getSex() == '0'){
					$defaultImagePath = 'default/image/person/defaultman.png';
				}elseif($person->getSex() == '1'){
					$defaultImagePath = 'default/image/person/defaultwoman.png';
				}else{
					$defaultImagePath = 'default/image/person/default.png';
				}
				
				$image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
				  'path' => $defaultImagePath,
				  'filter' => '120x120',
				));
				
				$response->setContent(json_encode(array(
					'state' => 1,
					'image120x120' => $image120x120,
					'isUserOnline' => $isUserOnline,
				)));
			}else{
				$image = $personimageRepository->find($personimage_id);
				
				if($image && $person->getId() == $image->getPerson()->getId()){
					$images = $personimageRepository->findBy(array(
						'person' => $person
					));
					
					foreach ($images as $imageTemp) {
						$imageTemp->setCurrent(false);
						$em->persist($imageTemp);
					}
					
					$image->setCurrent(true);
					
					$em->persist($image);
					$em->flush();
					
					$image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
					  'path' => $image->getWebPath(),
					  'filter' => '120x120',
					));
					
					
					$response->setContent(json_encode(array(
						'state' => 1,
						'image120x120' => $image120x120,
						'isUserOnline' => $isUserOnline,
					)));
				}
			}
		}
		
        $response->headers->set('Content-Type', 'application/json');
		return $response;
    }
}
