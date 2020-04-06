<?php

namespace LocationBundle\Controller;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use AnnonceBundle\Entity\Annonces;
use LocationBundle\Entity\Velo;
use LocationBundle\Form\VelosType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;


class LocationController extends Controller
{
    public function indexAction()
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findAll();
        return $this->render('@Location/Velo/index.html.twig', array('velo' => $vel));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $velo = $em->getRepository('LocationBundle:Velo')->find($id);
        $em->remove($velo);
        $em->flush();
        $this->addFlash('success', 'Vélo Supprimée');
        return $this->redirect('/admin/Location/Velo');

    }

    public function showAction($id)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:Velo')->findOneById($id);;
        return $this->render('@Location/Velo/show.html.twig', array('velo' => $vel));
    }
    public function ajouterAction(Request $request)
    {
        $vel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();


        $velo = new Velo();
        $form = $this->createForm(VelosType::class, $velo);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici
            $em = $this->getDoctrine()->getManager();

            $matricule = rand().'-BASKEL-'.date('Y', time());
            $velo->setMatricule($matricule);
            $velo->setConstructeur($request->get('constructeur'));
            $velo->setEtat($request->get('etat'));
            $velo->setModel($request->get('model'));
            $velo->setPrix($request->get('prix'));
            $fich = $request->files->get('image');
            $new_name = rand() . '.' . $fich->getClientOriginalExtension();
            $fich->move($this->getParameter('Annonces'), $new_name);
            $velo->setImage($new_name);
            $pointRelais = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->find($request->get('ptl'));

            $velo->setPointRelais($pointRelais);

            $em->persist($velo);
            $this->addFlash('success', 'Vélo ajoutée avec succés');
            $em->flush() ;
            return $this->redirect('/admin/Location/Velo');
        }

        return $this->render('@Location/Velo/add.html.twig', array('form' => $form->createView(), 'ptrel' => $vel));
    }

    public function editAction(Request $request,$id)
    {
        $ptrel = $this->getDoctrine()->getRepository('LocationBundle:PointRelais')->findAll();

        $entityManager = $this->getDoctrine()->getManager();
        $velo = $entityManager->getRepository('LocationBundle:Velo')->findOneById($id);

        $form = $this->createForm(VelosType::class, $velo);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //ici

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
            return $this->redirect('/admin/Location/Velo');
        }
        return $this->render('@Location/Velo/update.html.twig', array('form' => $form->createView(),"velo"=>$velo , 'ptrel' => $ptrel));

    }

}
