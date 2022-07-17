<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
use App\Entity\Habitats;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    // public function __construct(CommentairesRepository $commsRepository) {
    
    //     $this->commsRepository = $commsRepository;
    // }

    public function __construct(Security $security)
    {
    $this->security = $security;
    }



    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine-> getRepository(Commentaires::class); 
        $repoHabitat = $doctrine-> getRepository(Habitats::class); 
        //show only last three comments
        $commentaires = $repo->findBy(array(),array('id'=>'DESC'),3,0);
        $departement = $repoHabitat->findAll();
        $nombreDepersonne = $repoHabitat->findAll( array('nombrePersonnesMax' => 'DESC'));
        $hebergementType = $repoHabitat->findAll();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'commentaires' => $commentaires ,
            'habitats' => $departement ,
            'habitats' =>  $nombreDepersonne ,
            'habitats' =>  $hebergementType 


        ]);
    }





}

