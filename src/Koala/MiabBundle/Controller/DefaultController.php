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
     * @Route("/", name = "miabIndex")
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


        $request = $this->getRequest();
        if( $request->getMethod() == 'POST' )
        {
            // On fait le lien Requ??te <-> Formulaire.
            $form->bindRequest($request);
            $bottle->setCreateDate(new \DateTime());
            $bottle->setBottleHash(md5($bottle->getMessage() . date_format($bottle->getCreateDate(), 'Y-m-d H:i:s')));
            $nextDate = date('Y-m-d', strtotime(date_format($bottle->getCreateDate(), 'Y-m-d') . ' + ' . $bottle->getPeriodicity() . ' days'));
            $nextDate = new \DateTime($nextDate);
            $bottle->setNextApparitionDate($nextDate);
            if( $form->isValid() )
            {
                $em = $this->getDoctrine()->getEntityManager();
                // On l'enregistre notre objet $article dans la base de donn??es.
                $em->persist($bottle);
                $em->flush();
                return $this->redirect($this->generateUrl('miabIndex'));
            }
        }

        return array('formbottle' => $form->createView());
    }

    /**
     * @Route("/discover/{hash}", name = "showBottle")
     * @Template()
     */
    public function showBottleAction($hash)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $bottle = $em->createQueryBuilder()
                    ->select('b')
                    ->from('KoalaMiabBundle:Bottle',  'b')
                    ->where('b.bottleHash = \''.$hash.'\'')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();

         if (!$bottle) {
                throw $this->createNotFoundException('Unable to find this bottle.');
        }

        return array('bottle' => $bottle);
    }

}
