<?php

namespace LocationBundle\Controller;
use AnnonceBundle\Entity\Annonces;
use LocationBundle\Entity\PointRelais;
use LocationBundle\Entity\Velo;
use LocationBundle\Form\PtrType;
use LocationBundle\Form\VelosType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;


class PtRelaisController extends Controller
{
    public function indexAction()
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();
        return $this->render('@Location/PtRelais/index.html.twig', array('ptrel' => $vel));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ptl = $em->getRepository('LocationBundle:PointRelais')->find($id);
        $em->remove($ptl);
        $em->flush();
        $this->addFlash('success', 'Points Relais Supprimée');
        return $this->redirect('/admin/Location/Points_Relais');

    }

    public function showAction($id)
    {
        $ptrell = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();
        $ptrel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findOneById($id);
        $velo = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();
        return $this->render('@Location/PtRelais/show.html.twig', array('ptrel' => $ptrel,'velo'=>$velo,'ptrell'=>$ptrell));
    }
    public function ajouterAction(Request $request)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();

        $ptll = new PointRelais();
        $form = $this->createForm(PtrType::class,$ptll) ;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();

            $ptll->setNom($request->get('nom'));
            $long = $request->get('longitude');
            $lat = $request->get('latitude');
            $coord=$long.",".$lat ;
            $ptll->setCoordonnees($coord);



            $em->persist($ptll);
            $this->addFlash('success', 'Points Relais ajoutée avec succés');
            $em->flush() ;
            return $this->redirect('/admin/Location/Points_Relais');
        }

        return $this->render('@Location/PtRelais/add.html.twig', array('form' => $form->createView(),'ptrel'=>$vel));
    }

    public function editAction(Request $request,$id)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();

        $entityManager = $this->getDoctrine()->getManager();
        $ptrel = $entityManager->getRepository('LocationBundle:PointRelais')->findOneById($id);

        $form = $this->createForm(PtrType::class, $ptrel);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $ptrel->setNom($request->get('nom'));
            $long = $request->get('longitude');
            $lat = $request->get('latitude');
            $coord=$long.",".$lat ;
            $ptrel->setCoordonnees($coord);

            $entityManager->flush();
            $this->addFlash('success', 'Points de Relais Modifiée avec succés');
            return $this->redirect('/admin/Location/Points_Relais');
        }
        return $this->render('@Location/PtRelais/update.html.twig', array('form' => $form->createView(),"velo"=>$ptrel,'ptrel'=>$vel));

    }

}
