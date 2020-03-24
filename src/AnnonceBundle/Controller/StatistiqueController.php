<?php

namespace AnnonceBundle\Controller;

use  AnnonceBundle\Entity\Annonces;
use  AnnonceBundle\Entity\User;
use AnnonceBundle\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Query\Expr;

class StatistiqueController extends Controller
{
    public function indexAction()
    {
   // pour les stat vente
        $tout = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findAll() ;

        $query1 =$this->getstatV(100) ;
        $query2 =$this->getstatV(150) ;
        $query3 =$this->getstatV(200) ;
        $query4 =$this->getstatV(250) ;
        $query5 =$this->getstatV(300) ;
        $query6 =$this->getstatV(350) ;
        $query7 =$this->getstatV(400) ;
        $query8 =$this->getstatV(450) ;
        $query9 =$this->getstatV(500) ;
        $query10 =$this->getstatV(550) ;
        $query11 =$this->getstatV(600) ;
        $query12 =$this->getstatV(650) ;
        $query13 =$this->getstatV(700) ;
        $query14 =$this->getstatV(750) ;
        $query15 =$this->getstatV(800) ;
        $query16 =$this->getstatV(850) ;
        $query17 =$this->getstatV(900) ;
        $query18 =$this->getstatV(950) ;
        $array = array(
            "var1" => $query1,
            "var2" => $query2,
            "var3" => $query3,
            "var4" => $query4,
            "var5" => $query5,
            "var6" => $query6,
            "var7" => $query7,
            "var8" => $query8,
            "var9" => $query9,
            "var10" => $query10,
            "var11" => $query11,
            "var12" => $query12,
            "var13" => $query13,
            "var14" => $query14,
            "var15" => $query15,
            "var16" => $query16,
            "var17" => $query17,
            "var18" => $query18,
        );
        //pour les stat location
        $quer1 =$this->getstatL(3) ;
        $quer2 =$this->getstatL(4) ;
        $quer3 =$this->getstatL(5) ;
        $quer4 =$this->getstatL(6) ;
        $quer5 =$this->getstatL(7) ;
        $quer6 =$this->getstatL(8) ;
        $quer7 =$this->getstatL(9) ;
        $quer8 =$this->getstatL(10) ;
        $quer9 =$this->getstatL(11) ;
        $quer10 =$this->getstatL(12) ;
        $quer11 =$this->getstatL(13) ;
        $quer12 =$this->getstatL(14) ;
        $quer13 =$this->getstatL(15) ;
        $quer14 =$this->getstatL(16) ;
        $quer15 =$this->getstatL(17) ;
        $quer16 =$this->getstatL(18) ;
        $quer17 =$this->getstatL(19) ;
        $quer18 =$this->getstatL(20) ;
        $arrayL= array(
            "var1" => $quer1,
            "var2" => $quer2,
            "var3" => $quer3,
            "var4" => $quer4,
            "var5" => $quer5,
            "var6" => $quer6,
            "var7" => $quer7,
            "var8" => $quer8,
            "var9" => $quer9,
            "var10" => $quer10,
            "var11" => $quer11,
            "var12" => $quer12,
            "var13" => $quer13,
            "var14" => $quer14,
            "var15" => $quer15,
            "var16" => $quer16,
            "var17" => $quer17,
            "var18" => $quer18,
        );
        $pech =$this->getporcentage(1);
        $ploc= $this->getporcentage(3) ;
        $pvente =$this->getporcentage(2);
        $stat= array(
            "ech" => $pech,
            "vente" => $pvente,
            "loc" => $ploc,
        );
        $all=$this->CountAll() ;
        $d= new \DateTime('now')  ;




        return $this->render('@Annonce/Statistique/index.html.twig', array('annonces' =>  $array,'annoncesE'=>$arrayL,'stat'=>$stat,'all'=>$all,'d'=>$d,'tout'=>$tout));

    }
    public function getstatV($i1){
        $ann = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findByType(2);
        $n = count($ann) ;
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.prix >= :i1')->AndWhere('p.prix < :i1+50')->setParameter('i1', $i1);;
       $annonces = $query1->getQuery()->getResult();
         $val= (count($annonces)/$n)*100 ;
         return number_format($val,2) ;
    }
    public function getstatL($i1){
        $ann = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findByType(3);
        $n = count($ann) ;
        $repository = $this->getDoctrine()->getRepository(Annonces::class);
        $query1=  $repository->createQueryBuilder('p')->where('p.prixHeure >= :i1')->AndWhere('p.prixHeure < :i1+1')->setParameter('i1', $i1);;
        $annonces = $query1->getQuery()->getResult();
        $val= (count($annonces)/$n)*100 ;
        return number_format($val,2) ;
    }
    public function getporcentage($i1){
        $tout = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findAll() ;
        $n=count($tout) ;
        $ann = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findByType($i1);
        $n1 = count($ann) ;
       $pourc =  ($n1/$n)*100 ;
        return number_format($pourc  ,2) ;
    }
    public function CountAll(){
        $tout = $this->getDoctrine()->getRepository('AnnonceBundle:Annonces')->findAll() ;
        $n=count($tout) ;
        return $n ;
    }

}
