<?php

namespace AnnonceBundle\Controller;

use  AnnonceBundle\Entity\Annonces;
use  AnnonceBundle\Entity\User;
use AnnonceBundle\Form\AnnoncesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FAnnonceVController extends Controller
{

    public function indexAction(Request $request)
    {
        $user = $this->getUser() ;
        $userid = $user->getUserId() ;
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.type= 2')->AndWhere('p.user = :usera')->setParameter('usera', $user);;
        $annoncesuser = $query1->getQuery()->getResult();
        $nbr=  count($annoncesuser) ;
        $annonces =  $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 2],
            ['date' => 'DESC']) ;
        $paginator =$this->get('knp_paginator') ;
        $annoncesv = $paginator->paginate($annonces, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            12/*page number*/
        ) ;


        return $this->render('@Annonce/Fannoncesv/index.html.twig', array('annoncesv' => $annoncesv,'annoncesuser'=>$annoncesuser,'nbr'=>$nbr,'user'=>$userid));
    }
    public function showAction($id)
    {
        $annonces = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findOneByAnnId($id);
        $annoncesv = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 2],
            ['date' => 'DESC']) ;
        return $this->render('@Annonce/Fannoncesv/show.html.twig', array('annonce' => $annonces,'annoncesv'=>$annoncesv));
    }
    public function showuserAction($id)
    {
        $user = $this->getUser() ;
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.type= 2')->AndWhere('p.user = :usera')->setParameter('usera', $user);;
        $annonces = $query1->getQuery()->getResult();
        return $this->render('@Annonce/Fannoncesv/foruser.htm.twig', array('annonces' => $annonces));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('AnnonceBundle:Annonces')->find($id);
        $em->remove($annonce);
        $em->flush();
        //$this->addFlash('success', 'Annonce vente Supprimée');
        return $this->redirect('/front/foruser/'.$annonce->getUser()->getUserId() )   ;


    }
    public function ajouterAction(Request $request)
    {
        $user = $this->getUser() ;
        $deleg = $this->getDoctrine()->getRepository('AnnonceBundle:Delegation')->findByIdGouv(2);
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $annonce->setUser($user);
            $annonce->setSignals(0);
            $annonce->setType(2);
            $annonce->setDate(new \DateTime('now'));
            //ici
            $annonce->setDescription($request->get('desc'));
            $annonce->setNumTel($request->get('numtel'));
            $annonce->setGouvernorat($request->get('gouvernerat'));
            $annonce->setDelegation($request->get('delegation'));
            $annonce->setAddress($request->get('address'));
            $fich = $request->files->get('photo');
            $new_name = rand() . '.' . $fich->getClientOriginalExtension();
            $fich->move($this->getParameter('Annonces'), $new_name);
            $annonce->setPhoto($new_name);
            $annonce->setPrix($request->get('prix'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $this->addFlash('success', 'Annonce vente ajoutée avec succés');
            $em->flush() ;
            return $this->redirect('/front/all_Vente');
        }

        return $this->render('@Annonce/Fannoncesv/add.html.twig', array('form' => $form->createView(), 'delegs' => $deleg));
    }
    public function editAction(Request $request,$id)
    {
        $user = $this->getUser() ;
        $userid = $user->getUserId() ;
        $deleg = $this->getDoctrine()->getRepository('AnnonceBundle:Delegation')->findByIdGouv(2);
        $delega = $this->getDoctrine()->getRepository('AnnonceBundle:Delegation')->findByIdGouv(1);
        $entityManager = $this->getDoctrine()->getManager();
        $annonce = $entityManager->getRepository('AnnonceBundle:Annonces')->findOneByAnnId($id) ;
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $annonce->setUser($annonce->getUser());
            $annonce->setSignals(0);
            $annonce->setType(2);
            $annonce->setDate(new \DateTime('now'));
            //ici
            $annonce->setDescription($request->get('desc'));
            $annonce->setNumTel($request->get('numtel'));
            $annonce->setGouvernorat($request->get('gouvernerat'));
            $annonce->setDelegation($request->get('delegation'));
            $annonce->setAddress($request->get('address'));
            if($request->files->get('photo') !=null) {
                $fich = $request->files->get('photo');
                $new_name = rand() . '.' . $fich->getClientOriginalExtension();
                $fich->move($this->getParameter('Annonces'), $new_name);
                //remove file
                $filesystem = new Filesystem();
                $filesystem->remove($this->getParameter('Annonces')."/".$annonce->getPhoto());
                $annonce->setPhoto($new_name);
            }else  $annonce->setPhoto($annonce->getPhoto());
            $annonce->setPrix($request->get('prix'));
            $entityManager->flush();
            return $this->redirect('/front/all_Vente');
            $this->addFlash('success', 'Annonce vente Modifiée avec succés');

        }
        return $this->render('@Annonce/Fannoncesv/update.html.twig', array('form' => $form->createView(), 'delegs' => $deleg,"annonce"=>$annonce,'delegas'=>$delega,'user'=>$userid));

    }


}
