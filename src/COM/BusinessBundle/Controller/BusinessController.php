<?php

namespace COM\BusinessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use COM\BusinessBundle\Entity\Product;
use COM\BusinessBundle\Form\Type\ProductInit;
use COM\BusinessBundle\Form\Type\ProductInitType;

use COM\BusinessBundle\Entity\Productimage;
use COM\BusinessBundle\Form\Type\ProductimageType;

class BusinessController extends Controller
{
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		
		$products = $productRepository->findBy(array(
			'deleted' => false,
		));
		
		$data = array(
			'products' => $products,
			'treeview' => 'business',
			'treeviewmenu' => 'product',
		);
		
		$session = $request->getSession();
		$dataTooltip = $session->get('dataTooltip');
		if($dataTooltip){		
			$data['dataTooltip'] = $dataTooltip;			
			$session->remove('dataTooltip');
		}
		
        return $this->render('COMBusinessBundle:business:index.html.twig', $data);
    }
	
    public function addProductAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		$categoryRepository = $em->getRepository('COMBusinessBundle:Category');
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$productInit = new ProductInit();
		$formInitProduct = $this->get('form.factory')->create(ProductInitType::class, $productInit);
		
		if ($formInitProduct->handleRequest($request)->isValid()) {
			
			$product = new Product();
			$product->setName($productInit->getName());
			$product->setDescription($productInit->getDescription());
			$product->setReference($productInit->getReference());
			$product->setQuantityalert($productInit->getQuantityalert());
			$product->setDeleted(false);
			
			$category = $categoryRepository->find($productInit->getCategoryId());
			$product->setCategory($category);
			
			$brand = $brandRepository->find($productInit->getBrandId());
			$product->setBrand($brand);
			
			//slug
			$slug = $platformService->sluggify($product->getName());
			
			$slugtmp = $slug;
			$notSlugs = array(
				"user", 
				"users", 
				"business",
				"brand",
				"brands",
				"stock",
				"stocks",
				"transaction",
				"transactions",
				"gain",
				"gains",
				"expenditure",
				"expenditures",
				"staff",
				"employee",
				"employees",
				"student",
				"students",
				"course",
				"courses",
				"group",
				"groups",
				"studentgroup",
				"studentgroups",
				"taking",
				"takings",
			);
            $isSluggable = true;
            $i = 2;
            do {
                $producttmp = $productRepository->findOneBy(array(
					'slug' => $slugtmp
				));
				if($producttmp || in_array($slugtmp, $notSlugs)){
					$slugtmp = $slug."-".$i;
					$i++;
				}
				else{
					$isSluggable = false;
				}
            } 
            while ($isSluggable);
            $slug = $slugtmp;
			
			$product->setSlug($slug);
			
			$em->persist($product);
			$em->flush();
			
			$session = $request->getSession();
			$urlProduct = $this->get('router')->generate('com_business_view_product', array('product_id' => $product->getId()));
			$dataTooltip = array(
				'message' => "L'ajout de l'article &quot;<a href=\"".$urlProduct."\">".$product->getName()."</a>&quot; est fait avec succès.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_home');
			return new RedirectResponse($url);
		}
		
		$categories = $categoryRepository->findAll();
		$brands = $brandRepository->findBy(array(
			'deleted' => false,
		));
		
        return $this->render('COMBusinessBundle:business:add-product.html.twig', array(
			'categories' => $categories,
			'brands' => $brands,
			'treeview' => 'business',
			'treeviewmenu' => 'product',
		));
    }
	
    public function deleteProductAction($product_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		$stockRepository = $em->getRepository('COMBusinessBundle:Stock');
		
		$product = $productRepository->find($product_id);
		$session = $request->getSession();
		
		if($product){
			$stocks = $stockRepository->findBy(array(
				'product' => $product,
				'deleted' => false,
			));
			
			if($stocks){
				$dataTooltip = array(
					'type' => 'warning',
					'message' => "Des mouvements de stock sont liés à cet article, la suppression n'est pas encore possible.",
				);
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_home');
				return new RedirectResponse($url);
			}else{
				$product->setDeleted(true);
				$em->flush();
					
				$dataTooltip = array(
					'message' => "La suppression de l'article &quot;".$product->getName()."&quot; est faite avec succès.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_home');
				return new RedirectResponse($url);
			}
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un article qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_home');
			return new RedirectResponse($url);
		}
    }
	
    public function viewProductBySlugAction($slug, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		
		$product = $productRepository->findOneBy(array(
			'slug' => $slug,
		));
		
		if($product){
			$url = $this->get('router')->generate('com_business_view_product', array(
				'product_id' => $product->getId(),
			));
			
			return new RedirectResponse($url);
		}else{
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

	
    public function viewProductAction($product_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$businessService = $this->container->get('com_business.business_service');
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		$stockRepository = $em->getRepository('COMBusinessBundle:Stock');
		$categoryRepository = $em->getRepository('COMBusinessBundle:Category');
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		
		$product = $productRepository->find($product_id);
		
		if($product){
			$categories = $categoryRepository->findAll();
			$brands = $brandRepository->findAll();
			
			$stocks = $stockRepository->findBy(array(
				'product' => $product,
				'deleted' => false,
			));
			
			$stockins = $stockRepository->findBy(array(
				'product' => $product,
				'deleted' => false,
				'type' => false,
			));
			
			$stockouts = $stockRepository->findBy(array(
				'product' => $product,
				'deleted' => false,
				'type' => true,
			));
			
			$qteStock = $businessService->getQteStock($product);
			$qteStockin = 0;
			$qteStockout = 0;
			$priceStockin = 0;
			$priceStockout = 0;
			
			foreach ($stocks as $stock) {
				switch ($stock->getType()) {
					case 0:
						$qteStockin += $stock->getQuantity();
						$priceStockin += $stock->getQuantity() * $stock->getPrice() ;
						break;
					case 1:
						$qteStockout += $stock->getQuantity();
						$priceStockout += $stock->getQuantity() * $stock->getPrice() ;
						break;
				}
			}
			
			$data = array(
				'product' => $product,
				'categories' => $categories,
				'brands' => $brands,
				'stocks' => $stocks,
				'stockins' => $stockins,
				'stockouts' => $stockouts,
				'qteStockin' => $qteStockin,
				'qteStockout' => $qteStockout,
				'priceStockin' => $priceStockin,
				'priceStockout' => $priceStockout,
				'qteStock' => $qteStock,
				'treeview' => 'business',
				'treeviewmenu' => 'product',
			);
			
			$session = $request->getSession();
			$dataTooltip = $session->get('dataTooltip');
			if($dataTooltip){		
				$data['dataTooltip'] = $dataTooltip;			
				$session->remove('dataTooltip');
			}
			
			return $this->render('COMBusinessBundle:business:view-product.html.twig', $data);
		}else{
			$session = $request->getSession();
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un article qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_home');
			return new RedirectResponse($url);
		}
    }

	public function changeImagePopupAction($product_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
        $productimageRepository = $em->getRepository('COMBusinessBundle:Productimage');
		
		$product = $productRepository->find($product_id);
		$images = $productimageRepository->findBy(array(
			'product' => $product
		));
		$current = $productimageRepository->findOneBy(array(
			'product' => $product,
			'current' => true,
		));
		
        $response = new Response();

		$content = $this->renderView('COMBusinessBundle:business:change_image_popup.html.twig', array(
			'product' => $product,
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

	public function uploadProductimageAction($product_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
        $productimageRepository = $em->getRepository('COMBusinessBundle:Productimage');
        
        $image = new Productimage();
		$product = $productRepository->find($product_id);
        
		$formImage = $this->get('form.factory')->create(ProductimageType::class, $image);
		
        $formImage->handleRequest($request);
		
        $response = new Response();

		$response->setContent(json_encode(array(
			'state' => 0,
		)));

        if ($formImage->isValid()) {
            $images = $productimageRepository->findBy(array(
				'product' => $product
			));
            
            foreach ($images as $imageTemp) {
                $imageTemp->setCurrent(false);
				$em->persist($imageTemp);
            }
			
            $image->setCurrent(true);
            $image->setProduct($product);
			
            $em->persist($image);
            $em->flush();
			
            $image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
			  'path' => $image->getWebPath(),
			  'filter' => '120x120',
			));
			
            $imageItemContent = $this->renderView('COMBusinessBundle:business:include/productimage_item.html.twig', array(
			  'product' => $product,
			  'image' => $image,
			  'classActive' => 'active'
			));
			
            $response->setContent(json_encode(array(
                'state' => 1,
                'image120x120' => $image120x120,
                'imageItemContent' => $imageItemContent,
            )));
        }
		
		$response->headers->set('Content-Type', 'application/json');
		return $response;
    }

	public function deleteProductimageAction($product_id, $productimage_id)
    {
        $em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
        $productimageRepository = $em->getRepository('COMBusinessBundle:Productimage');
		
		$product = $productRepository->find($product_id);
		
		$image = $productimageRepository->find($productimage_id);
		
        $response = new Response();
		
		$response->setContent(json_encode(array(
			'state' => 0,
		)));
		
		if($product && $image){
			if($product->getId() == $image->getProduct()->getId()){
				$imageId = $image->getId();
				$em->remove($image);
				$em->flush();
				
				$current = $productimageRepository->findOneBy(array(
					'product' => $product,
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
					$defaultImagePath = 'default/image/product/default.png';
					
					$image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
					  'path' => $defaultImagePath,
					  'filter' => '120x120',
					));
					
					$response->setContent(json_encode(array(
						'state' => 1,
						'imageId' => $imageId,
						'image120x120' => $image120x120,
						'isCurrent' => true,
					)));
				}
			}
		}
		
        $response->headers->set('Content-Type', 'application/json');
		return $response;
    }

	public function selectProductimageAction($product_id, $productimage_id)
    {
        $em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
        $productimageRepository = $em->getRepository('COMBusinessBundle:Productimage');
		
		$product = $productRepository->find($product_id);
		
		$response = new Response();
		
		$response->setContent(json_encode(array(
			'state' => 0,
		)));
		
		if($product){
			if($productimage_id == 0){
				$images = $productimageRepository->findBy(array(
					'product' => $product
				));

				foreach ($images as $image) {
					$image->setCurrent(false);
					$em->persist($image);
				}
				$em->flush();
				
				$defaultImagePath = 'default/image/product/default.png';
				
				$image120x120 = $this->renderView('COMPlatformBundle:platform:image_thumb.html.twig', array(
				  'path' => $defaultImagePath,
				  'filter' => '120x120',
				));
				
				$response->setContent(json_encode(array(
					'state' => 1,
					'image120x120' => $image120x120,
				)));
			}else{
				$image = $productimageRepository->find($productimage_id);
				
				if($image && $product->getId() == $image->getProduct()->getId()){
					$images = $productimageRepository->findBy(array(
						'product' => $product
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
					)));
				}
			}
		}
		
        $response->headers->set('Content-Type', 'application/json');
		return $response;
    }
	
    public function editProductAction($product_id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$productRepository = $em->getRepository('COMBusinessBundle:Product');
		$categoryRepository = $em->getRepository('COMBusinessBundle:Category');
		$brandRepository = $em->getRepository('COMBusinessBundle:Brand');
		$platformService = $this->container->get('com_platform.platform_service');
		
		$product = $productRepository->find($product_id);
		$session = $request->getSession();
		
		if($product){
			$productInit = new ProductInit();
			
			$productInit->setName($product->getName());
			$productInit->setReference($product->getReference());
			$productInit->setDescription($product->getDescription());
			$productInit->setQuantityalert($product->getQuantityalert());
			$productInit->setCategoryId($product->getCategory()->getId());
			if($product->getBrand()){
				$productInit->setBrandId($product->getBrand()->getId());
			}else{
				$productInit->setBrandId(0);
			}
			
			
			$formInitProduct = $this->get('form.factory')->create(ProductInitType::class, $productInit);
			
			$formInitProduct->handleRequest($request);
			
			if ($formInitProduct->isValid()) {
				
				$product->setName($productInit->getName());
				$product->setDescription($productInit->getDescription());
				$product->setReference($productInit->getReference());
				$product->setQuantityalert($productInit->getQuantityalert());
				
				$category = $categoryRepository->find($productInit->getCategoryId());
				$product->setCategory($category);
				
				$brand = $brandRepository->find($productInit->getBrandId());
				$product->setBrand($brand);
				
				//slug
				$slug = $platformService->sluggify($product->getName());
				
				$slugtmp = $slug;
				$notSlugs = array(
					"user", 
					"users", 
					"business",
					"brand",
					"brands",
					"stock",
					"stocks",
					"transaction",
					"transactions",
					"gain",
					"gains",
					"expenditure",
					"expenditures",
					"staff",
					"employee",
					"employees",
					"student",
					"students",
					"course",
					"courses",
					"group",
					"groups",
					"studentgroup",
					"studentgroups",
					"taking",
					"takings",
				);
				$isSluggable = true;
				$i = 2;
				do {
					$producttmp = $productRepository->findOneBy(array(
						'slug' => $slugtmp
					));
					if(($producttmp && $producttmp->getId() != $product->getId()) || in_array($slugtmp, $notSlugs)){
						$slugtmp = $slug."-".$i;
						$i++;
					}
					else{
						$isSluggable = false;
					}
				} 
				while ($isSluggable);
				$slug = $slugtmp;
				
				$product->setSlug($slug);
				
				
				$em->persist($product);
				$em->flush();
				
				$dataTooltip = array(
					'message' => "L'édition de l'article &quot;".$product->getName()."&quot; est faite avec succès.",
				);
				
				$session->set('dataTooltip', $dataTooltip);
				
				$url = $this->get('router')->generate('com_business_view_product', array(
					'product_id' => $product->getId()
				));
				return new RedirectResponse($url);
			}
			
			$categories = $categoryRepository->findAll();
			
			$brands = $brandRepository->findBy(array(
				'deleted' => false,
			));
			
			return $this->render('COMBusinessBundle:business:edit-product.html.twig', array(
				'product' => $product,
				'productInit' => $productInit,
				'categories' => $categories,
				'brands' => $brands,
				'treeview' => 'business',
				'treeviewmenu' => 'product',
			));
		}else{
			$dataTooltip = array(
				'type' => 'warning',
				'message' => "Vous vous tentez à accéder à un article qui n'éxiste pas.",
			);
			
			$session->set('dataTooltip', $dataTooltip);
			
			$url = $this->get('router')->generate('com_business_home');
			return new RedirectResponse($url);
		}
    }
}
