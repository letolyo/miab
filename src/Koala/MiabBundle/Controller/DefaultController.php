<?php

namespace Koala\MiabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Koala\MiabBundle\Form\BottleType;
use Koala\MiabBundle\Entity\Bottle;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/throwBottle", name = "throwBottle")
     * @Template()
     */
    public function throwBottleAction ()
    {
        $bottle = new Bottle();
        $form = $this->createForm(new BottleType(), $bottle);
        return array('formbottle' => $form->createView());
    }

}
