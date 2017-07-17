<?php

namespace COM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('COMUserBundle:user:index.html.twig');
    }
    public function loginAction()
    {
        return $this->render('COMUserBundle:user:login.html.twig');
    }
}
