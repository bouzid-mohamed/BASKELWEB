<?php

namespace LocationBundle\Controller;
use AnnonceBundle\Entity\Annonces;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use LocationBundle\Entity\Velo;
use LocationBundle\Entity\VeloPtRelais;

use LocationBundle\Form\ResType;
use LocationBundle\Form\VelosType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints\Date;


class ReservationController extends Controller
{
    public function indexAction()
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:VeloPtRelais')->findAll();
        return $this->render('@Location/Reservation/index.html.twig', array('velo' => $vel));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $velo = $em->getRepository('LocationBundle:VeloPtRelais')->find($id);
        $em->remove($velo);
        $em->flush();
        $this->addFlash('success', 'Réservation Supprimée');
        return $this->redirect('/admin/Location/Reservations');

    }

  /*  public function showAction($id)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findOneById($id);;
        return $this->render('@Location/Velo/show.html.twig', array('velo' => $vel));
    }
  */

    function getHeure($birthdate){
        $adjust = (date("md") >= date("md", strtotime($birthdate))) ? 0 : -1; // Si aún no hemos llegado al día y mes en este año restamos 1
        $years = date("Y") - date("Y", strtotime($birthdate)); // Calculamos el número de años
        return $years + $adjust; // Sumamos la diferencia de años más el ajuste
    }


    public function ajouterAction(Request $request)
    {
        $allvelo = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();
        $res = new VeloPtRelais();
        $form = $this->createForm(ResType::class, $res);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();

            $res->setIdUser($this->getUser());
            $res->setIdVelo($this->getDoctrine()->getRepository('LocationBundle:Velo')->find($request->get('vel')) );
            $res->setDateLocation(new \DateTime($request->get('datel')));
            $res->setDateF(new \DateTime($request->get('datef')));

            $res->setPrixlocation($this->getDoctrine()->getRepository('LocationBundle:Velo')->find($request->get('vel'))->getPrix());

            $em->persist($res);
            $this->addFlash('success', 'Reservation ajoutée avec succés ');
            $em->flush() ;
            return $this->redirect('/admin/Location/Reservations');
        }
        return $this->render('@Location/Reservation/add.html.twig', array('form' => $form->createView(), 'velo' => $allvelo));
    }
    public function pdfAction($id)
    {
        $velo = $this->getDoctrine()->getRepository('LocationBundle:VeloPtRelais')->findOneById($id);;
        $html = $this->renderView('@Location/Reservation/pdf.html.twig', array('velos'  => $velo));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }
  /*
    public function editAction(Request $request,$id)
    {
        $ptrel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();

        $entityManager = $this->getDoctrine()->getManager();
        $velo = $entityManager->getRepository('LocationBundle:Velo')->findOneById($id);

        $form = $this->createForm(VelosType::class, $velo);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $velo->setMatricule($request->get('matricule'));
            $velo->setConstructeur($request->get('constructeur'));
            $velo->setEtat($request->get('etat'));
            $velo->setModel($request->get('model'));
            $velo->setPrix($request->get('prix'));
            if($request->files->get('image') !=null) {
                $fich = $request->files->get('image');
                $new_name = rand() . '.' . $fich->getClientOriginalExtension();
                $fich->move($this->getParameter('Annonces'), $new_name);
                //remove file
                $filesystem = new Filesystem();
                $filesystem->remove($this->getParameter('Annonces')."/".$velo->getImage());
                $velo->setImage($new_name);
            }else  $velo->setImage($velo->getImage());

            $entityManager->flush();
            $this->addFlash('success', 'Vélo Modifiée avec succés');
            return $this->redirect('/Location/Velo');
        }
        return $this->render('@Location/Velo/update.html.twig', array('form' => $form->createView(),"velo"=>$velo , 'ptrel' => $ptrel));

    }
  */
}
