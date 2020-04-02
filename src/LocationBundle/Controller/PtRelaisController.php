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

   /* public function showAction($id)
    {
        $ptl = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findOneById($id);;
        return $this->render('@Location/PtRelais/show.html.twig', array('ptl' => $ptl));
    }
   */
    public function ajouterAction(Request $request)
    {

        $ptll = new PointRelais();
        $form = $this->createForm(PtrType::class,$ptll) ;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();

            $ptll->setNom($request->get('nom'));
            $long = $request->get('longitude');
            $lat = $request->get('latitude');
            $coord=$lat.",".$long ;
            $ptll->setCoordonnees($coord);



            $em->persist($ptll);
            $this->addFlash('success', 'Points Relais ajoutée avec succés');
            $em->flush() ;
            return $this->redirect('/admin/Location/Points_Relais');
        }

        return $this->render('@Location/PtRelais/add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Request $request,$id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $ptrel = $entityManager->getRepository('LocationBundle:PointRelais')->findOneById($id);

        $form = $this->createForm(PtrType::class, $ptrel);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $ptrel->setNom($request->get('nom'));
            $long = $request->get('longitude');
            $lat = $request->get('latitude');
            $coord=$lat.",".$long ;
            $ptrel->setCoordonnees($coord);

            $entityManager->flush();
            $this->addFlash('success', 'Points de Relais Modifiée avec succés');
            return $this->redirect('/admin/Location/Points_Relais');
        }
        return $this->render('@Location/PtRelais/update.html.twig', array('form' => $form->createView(),"velo"=>$ptrel));

    }

}
