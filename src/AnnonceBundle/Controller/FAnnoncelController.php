<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\Entity\Annonces;
use AnnonceBundle\Form\AnnoncesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FAnnoncelController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getUser() ;
        $userid = $user->getUserId() ;
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.type= 3')->AndWhere('p.user = :usera')->setParameter('usera', $user);;
        $annoncesuser = $query1->getQuery()->getResult();
        $nbr=  count($annoncesuser) ;
        $annonces =  $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 3],
            ['date' => 'DESC']) ;
        $paginator =$this->get('knp_paginator') ;
        $annoncesv = $paginator->paginate($annonces, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            12/*page number*/
        ) ;
        return $this->render('@Annonce/Fannoncesl/index.html.twig', array('annoncesv' => $annoncesv,'annoncesuser'=>$annoncesuser,'nbr'=>$nbr,'user'=>$userid));
    }
    public function showAction($id)
    {
        $annonces = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findOneByAnnId($id);
        $annoncesv = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 3],
            ['date' => 'DESC']) ;
        return $this->render('@Annonce/Fannoncesl/show.html.twig', array('annonce' => $annonces,'annoncesv'=>$annoncesv));
    }
    public function showuserAction($id)
    {
        $user = $this->getUser() ;
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.type= 3')->AndWhere('p.user = :usera')->setParameter('usera', $user);;
        $annonces = $query1->getQuery()->getResult();
        return $this->render('@Annonce/Fannoncesl/foruser.html.twig', array('annonces' => $annonces));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('AnnonceBundle:Annonces')->find($id);
        $em->remove($annonce);
        $em->flush();
        //$this->addFlash('success', 'Annonce vente Supprimée');
        return $this->redirect('/front/foruserl/'.$annonce->getUser()->getUserId() )   ;


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
            $annonce->setType(3);
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
            $annonce->setPrixJour($request->get('prixjour'));
            $annonce->setPrixHeure($request->get('prixheure'));
            $entityManager->flush();
            return $this->redirect('/front/all_Location');
            $this->addFlash('success', 'Annonce Location Modifiée avec succés');

        }
        return $this->render('@Annonce/Fannoncesl/update.html.twig', array('form' => $form->createView(), 'delegs' => $deleg,"annonce"=>$annonce,'delegas'=>$delega,'user'=>$userid));

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
            $annonce->setType(3);
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
            $annonce->setPrixJour($request->get('prixjour'));
            $annonce->setPrixHeure($request->get('prixheure'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $this->addFlash('success', 'Annonce Locatin ajoutée avec succés');
            $em->flush() ;
            return $this->redirect('/front/all_Location');
        }

        return $this->render('@Annonce/Fannoncesl/add.html.twig', array('form' => $form->createView(), 'delegs' => $deleg));
    }
}
