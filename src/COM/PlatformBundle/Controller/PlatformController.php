<?php

namespace COM\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PlatformController extends Controller
{
    public function collapseAction(Request $request)
    {		
		$collapse = $request->query->get('collapse');
		
		if($collapse == "true"){
			$collapse = true;
		}else{
			$collapse = false;
		}
		
		$session = $request->getSession();
		$dataCollapse = array(
			'collapse' => $collapse,
		);
		$session->set('dataCollapse', $dataCollapse);
		
		$data = array(
			'collapse' => $collapse
		);
		
		$response = new Response();
        $response->setContent(json_encode($data));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
    }
}
