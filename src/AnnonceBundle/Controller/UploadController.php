<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\Entity\Annonces;
use  AnnonceBundle\Entity\module ;
use AnnonceBundle\Form\AnnoncesType;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Symfony\Component\Validator\Constraints\Url;
use ZipArchive;
use Symfony\Component\HttpFoundation\File\UploadedFile ;


class UploadController extends Controller
{
    public function indexAction(Request $request)
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $fich = $request->files->get('fich');

            $nomf=stristr($fich->getClientOriginalName(),$fich->getClientOriginalExtension(),true) ;
            $this-> extract($fich ,"../src/") ;
            $this->moveFile("../src/".$nomf."/config.yml", "../app/config/config.yml");
            $this->moveFile("../src/".$nomf."/routing.yml", "../app/config/routing.yml");
            $this->moveFile("../src/".$nomf."/AppKernel.php", "../app/AppKernel.php");
            $this->lire_xml("../src/".$nomf."/module.xml") ;
            $this->addFlash('success', 'Module Ajouté avec succée');
            return $this->redirect('/admin/Annonce');
        }
        return $this->render('@Annonce/Upload/index.html.twig', array('form' => $form->createView()));
    }


    function moveFile($dossierSource, $dossierDestination)
    {
        copy($dossierSource,  $dossierDestination);
    }
    public function extract($from , $to) {
        $path = $from ;
        $zip = new ZipArchive;
        if ($zip->open($path) === true) {
            for($i = 0; $i < $zip->numFiles; $i++) {
                $zip->extractTo($to, array($zip->getNameIndex($i)));
            }

        }

    }
    public function lire_xml($chemin){
        $module=new Module() ;
        $xmldata = simplexml_load_file ($chemin);
        $module->setNom($xmldata->nom[0]) ;
        $module->setVersion($xmldata->version[0])  ;
        $module->setHref($xmldata->href[0]) ;
        $em = $this->getDoctrine()->getManager();
        $em->persist($module);
        $em->flush() ;
    }
    public function getModulesAction($max = 3){
        $tout = $this->getDoctrine()->getRepository('AnnonceBundle:module')->findAll() ;
        $s="" ;


        foreach ($tout as $tout ){


            $s= $s." <li><a href=".$tout->getHref().">".$tout->getNom()."</a></li>" ;
        }


        return new Response($s) ;
    }



}