<?php

namespace AnnonceBundle\Controller;
use  AnnonceBundle\Entity\Annonces;
use  AnnonceBundle\Entity\User;
use AnnonceBundle\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
class AnnonceLController extends Controller
{
    public function indexAction()
    {
        $annonces = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findBy(['type' => 3],
            ['date' => 'DESC']) ;
        return $this->render('@Annonce/Location/index.html.twig', array('annonces' => $annonces));
    }
    public function showAction($id)
    {
        $annonces = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findOneByAnnId($id);
        return $this->render('@Annonce/Location/show.html.twig', array('annonce' => $annonces));
    }


    public function editAction(Request $request,$id)
    {
        $deleg = $this->getDoctrine()->getRepository('AnnonceBundle:Delegation')->findByIdGouv(2);
        $delega = $this->getDoctrine()->getRepository('AnnonceBundle:Delegation')->findByIdGouv(1);
        $entityManager = $this->getDoctrine()->getManager();
        $annonce = $entityManager->getRepository('AnnonceBundle:Annonces')->findOneByAnnId($id);
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
            $this->addFlash('success', 'Annonce location Modifiée avec succés');
            return $this->redirect('/admin/Annonce/Location');
        }
        return $this->render('@Annonce/Location/update.html.twig', array('form' => $form->createView(), 'delegs' => $deleg,"annonce"=>$annonce,'delegas'=>$delega));
    }
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('AnnonceBundle:Annonces')->find($id);
        $em->remove($annonce);
        $em->flush();
        $this->addFlash('success', 'Annonce Location Supprimée');
        return $this->redirect('/admin/Annonce/Location');

    }

    public function ajouterAction(Request $request)
    {
        $user  = $this->getUser() ;
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
            $this->addFlash('success', 'Annonce Location ajoutée avec succés');
            $em->flush() ;
            return $this->redirect('/admin/Annonce/Location');
        }

        return $this->render('@Annonce/Location/add.html.twig', array('form' => $form->createView(), 'delegs' => $deleg));
    }
}
