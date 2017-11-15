<?php

namespace COM\BusinessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\BusinessBundle\Entity\Gain;
use COM\BusinessBundle\Form\Type\GainInit;
use COM\BusinessBundle\Form\Type\GainInitType;

class GainController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$gainRepository = $em->getRepository('COMBusinessBundle:Gain');
		
		$gains = $gainRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'gains' => $gains,
			'treeview' => 'business',
			'treeviewmenu' => 'gain',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMBusinessBundle:gain:index.html.twig', $data);
    }
	
	
    public function addGainAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$gainRepository = $em->getRepository('COMBusinessBundle:Gain');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$gainInit = new GainInit();
		$formInitGain = $this->get('form.factory')->create(GainInitType::class, $gainInit);
		
		if ($formInitGain->handleRequest($request)->isValid()) {
			
			$gain = new Gain();
			$gain->setName($gainInit->getName());
			$gain->setAmount($gainInit->getAmount());
			$gain->setDescription($gainInit->getDescription());
			
			$date = $platformService->getDate($gainInit->getDate());
			if($date){
				$gain->setDate($date);
			}else{
				$gain->setDate(new \DateTime());
			}
			
			$gain->setDeleted(false);

			$em->persist($gain);
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout du gain &quot;".$gain->getName()."&quot; est fait avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_gain');
			return new RedirectResponse($url);
		}

        return $this->render('COMBusinessBundle:gain:add-gain.html.twig', array(
			'gainInit' => $gainInit,
			'form' => $formInitGain,
			'treeview' => 'business',
			'treeviewmenu' => 'gain',
		));
    }
	
    public function viewGainAction($gain_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$gainRepository = $em->getRepository('COMBusinessBundle:Gain');
		
		$gain = $gainRepository->find($gain_id);
	
		if($gain){
			$data = array(
				'gain' => $gain,
				'treeview' => 'business',
				'treeviewmenu' => 'gain',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMBusinessBundle:gain:view-gain.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un gain qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_gain');
			return new RedirectResponse($url);
		}
    }
	
    public function editGainAction($gain_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$gainRepository = $em->getRepository('COMBusinessBundle:Gain');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$gainInit = new GainInit();
		
		$gain = $gainRepository->find($gain_id);

		if($gain){
			$gainInit->setName($gain->getName());
			$gainInit->setAmount($gain->getAmount());
			$gainInit->setDate($gain->getDate());
			$gainInit->setDescription($gain->getDescription());
			
			$formInitGain = $this->get('form.factory')->create(GainInitType::class, $gainInit);
			
			if ($formInitGain->handleRequest($request)->isValid()) {
				
				$gain->setName($gainInit->getName());
				$gain->setAmount($gainInit->getAmount());
				$gain->setDescription($gainInit->getDescription());
				
				$date = $platformService->getDate($gainInit->getDate());
				if($date){
					$gain->setDate($date);
				}else{
					$gain->setDate(new \DateTime());
				}

				$em->persist($gain);
				
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "L'édition sur le gain &quot;".$gain->getName()."&quot; est faite avec succès.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_view_gain', array(
					'gain_id' => $gain->getId()
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMBusinessBundle:gain:edit-gain.html.twig', array(
				'gain' => $gain,
				'gainInit' => $gainInit,
				'form' => $formInitGain->createView(),
				'treeview' => 'business',
				'treeviewmenu' => 'gain',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un gain qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_gain');
			return new RedirectResponse($url);
		}
    }
	
    public function  deleteGainAction($gain_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$gainRepository = $em->getRepository('COMBusinessBundle:Gain');
		
		$gain = $gainRepository->find($gain_id);
		
		if($gain){
			$gain->setDeleted(true);
			$em->flush();
				
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "La suppression du gain &quot;".$gain->getName()."&quot; est faite avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_gain');
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un gain qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_gain');
			return new RedirectResponse($url);
		}
    }
	
}
