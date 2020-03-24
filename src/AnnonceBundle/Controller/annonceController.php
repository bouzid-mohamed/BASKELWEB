<?php

namespace AnnonceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class annonceController extends Controller
{
    public function indexAction()
    {
        $annoncesv = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 2],
            ['date' => 'DESC']) ;
        $annoncesl = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 3],
            ['date' => 'DESC']) ;
        $annoncese = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 1],
            ['date' => 'DESC']) ;
        return $this->render('@Annonce/Fannonces/index.html.twig', array('annoncesv' => $annoncesv,'annoncesl' => $annoncesl,'annoncese' => $annoncese));
    }
}
