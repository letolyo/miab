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
        $em = $this->getDoctrine()->getEntityManager();
        $bottles = $em->createQueryBuilder()
                    ->select('b')
                    ->from('KoalaMiabBundle:Bottle',  'b')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult();

        $bottlesSet = array();
        foreach ($bottles as $bottle)
        {
            $now = new \DateTime();
            $nowDays = $now->getTimestamp() - $bottle->getCreateDate()->getTimestamp();
            $totalDays = $bottle->getNextApparitionDate()->getTimestamp() - $bottle->getCreateDate()->getTimestamp();
            if($now->getTimestamp() > $bottle->getNextApparitionDate()->getTimestamp()) {
                $percent = 0;
            } else {
                $percent = 100 - (30 + $nowDays / $totalDays * 70);
            }

            $bottle->setPercentVisibility($percent);
            $bottle->setDecalage(rand(1,90));
            if ( empty($bottlesSet) ) {
                $bottlesSet = array($bottle);
            } else {
                array_push($bottlesSet, $bottle);
            }
        }

        return array("bottles" => $bottlesSet);
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
                $this->get('session')->setFlash(
                    'notice',
                    'The bottle is sent ! Yay !'
                );
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
