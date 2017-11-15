<?php

namespace COM\BusinessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

use COM\BusinessBundle\Entity\Brand;
use COM\BusinessBundle\Form\Type\BrandInit;
use COM\BusinessBundle\Form\Type\BrandInitType;

class BrandController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		
		$brands = $brandRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'brands' => $brands,
			'treeview' => 'business',
			'treeviewmenu' => 'brand',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMBusinessBundle:brand:index.html.twig', $data);
    }
	
	
    public function addBrandAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$brandInit = new BrandInit();
		$formInitBrand = $this->get('form.factory')->create(BrandInitType::class, $brandInit);
		
		if ($formInitBrand->handleRequest($request)->isValid()) {
			
			$brand = new Brand();
			$brand->setName($brandInit->getName());
			$brand->setDescription($brandInit->getDescription());
			
			$brand->setDeleted(false);

			$em->persist($brand);
			$em->flush();
			
			$session = $request->getSession();
			$dataTooltip = array(
				'message' => "L'ajout de la marque &quot;".$brand->getName()."&quot; est fait avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_brand');
			return new RedirectResponse($url);
		}

        return $this->render('COMBusinessBundle:brand:add-brand.html.twig', array(
			'brandInit' => $brandInit,
			'form' => $formInitBrand,
			'treeview' => 'business',
			'treeviewmenu' => 'brand',
		));
    }
	
    public function viewBrandAction($brand_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		
		$brand = $brandRepository->find($brand_id);
		if($brand){
			
			$products = $productRepository->findBy(array(
				'brand' => $brand,
				'deleted' => false,
			));
			$data = array(
				'brand' => $brand,
				'products' => $products,
				'treeview' => 'business',
				'treeviewmenu' => 'brand',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMBusinessBundle:brand:view-brand.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une marque qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_brand');
			return new RedirectResponse($url);
		}
    }
	
    public function editBrandAction($brand_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$brandInit = new BrandInit();
		
		$brand = $brandRepository->find($brand_id);

		if($brand){
			$brandInit->setName($brand->getName());
			$brandInit->setDescription($brand->getDescription());
			
			$formInitBrand = $this->get('form.factory')->create(BrandInitType::class, $brandInit);
			
			if ($formInitBrand->handleRequest($request)->isValid()) {
				
				$brand->setName($brandInit->getName());
				$brand->setDescription($brandInit->getDescription());

				$em->persist($brand);
				
				$em->flush();
				
				$session = $request->getSession();
				$dataTooltip = array(
					'message' => "L'édition de la marque &quot;".$brand->getName()."&quot; est faite avec succès.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_view_brand', array(
					'brand_id' => $brand->getId()
				));
				return new RedirectResponse($url);
				
			}
			
			return $this->render('COMBusinessBundle:brand:edit-brand.html.twig', array(
				'brand' => $brand,
				'brandInit' => $brandInit,
				'form' => $formInitBrand->createView(),
				'treeview' => 'business',
				'treeviewmenu' => 'brand',
			));
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une marque qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_brand');
			return new RedirectResponse($url);
		}
    }
	
    public function  deleteBrandAction($brand_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		
		$brand = $brandRepository->find($brand_id);
		
		if($brand){
			$products =  $productRepository->findBy(array(
				'brand' => $brand,
				'deleted' => false,
			));
			
			$session = $request->getSession();
			if($products){				
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Des articles sont liés à la marque &quot;".$brand->getName()."&quot;, la suppression n'est pas encore possible.",
				);
				
			}else{
				$brand->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression de la marque &quot;".$brand->getName()."&quot; est faite avec succès.",
				);
			}
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_brand');
			return new RedirectResponse($url);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à une marque qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_brand');
			return new RedirectResponse($url);
		}
    }
	
}
