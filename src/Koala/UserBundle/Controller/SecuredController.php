<?php

namespace Koala\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecuredController extends Controller
{
    public function indexAction()
    {
		//this page requires the user to be logged in
        return $this->render('KoalaUserBundle:Secured:index.html.twig');
    }
	
}
