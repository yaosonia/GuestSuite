<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $donnes = file_get_contents('../data/data.json');
    	$data =json_decode($donnes);
        //var_dump($data); die();
        $tableau = [];

        //Parcours du tableau des données
        foreach ($data as $note) {

            //$note->rate renverra le tableau des notes par site
            # code...
            //on va parcourir les notes par site
            foreach($note->rates as $site=>$moyenne){
                if(isset($tableau[$site])){
                    $tableau[$site]+=round(($moyenne/count($data)),2);//si le tableau est défini, on fait le cumul
                }else{
                    $tableau[$site]=round(($moyenne/count($data)),2);
                }
            }
        }

        //sortie va récupérer le resultat final
        $sortie=[];

        foreach ($tableau as $site=>$moyenne) {
            $sortie[] =[
                "site"=>$site,
                "moy"=>$moyenne,
            ];
        }

        //header("Content-Type:application/json");
        //echo json_encode(array_keys($tableau));
        //echo json_encode(array_values($tableau));
        //exit;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'labels'=>json_encode(array_keys($tableau)),
            'data'=>json_encode(array_values($tableau)),  // Ici j'ai injecté la variable $tableau
            'donnees' => $sortie,
        ]);
    }
    
}
