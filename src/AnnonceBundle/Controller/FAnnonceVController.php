<?php

namespace AnnonceBundle\Controller;

use  AnnonceBundle\Entity\Annonces;
use  AnnonceBundle\Entity\User;
use AnnonceBundle\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Filesystem\Filesystem;

class FAnnonceVController extends Controller
{

    public function indexAction()
    {
        $user = $this->getDoctrine()->getRepository('AnnonceBundle:User')->findOneByUserId(1);
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.type= 2')->AndWhere('p.user = :usera')->setParameter('usera', $user);;
        $annoncesuser = $query1->getQuery()->getResult();
        $nbr=  count($annoncesuser) ;
        $annoncesv = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 2]);
        return $this->render('@Annonce/Fannoncesv/index.html.twig', array('annoncesv' => $annoncesv,'annoncesuser'=>$annoncesuser,'nbr'=>$nbr));
    }


}
