<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    // public function __construct(CommentairesRepository $commsRepository) {
    
    //     $this->commsRepository = $commsRepository;
    // }


    #[Route('/', name: 'app_home')]

    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine-> getRepository(Commentaires::class); 
        //show only last three comments
        $commentaires = $repo->findBy(array(),array('id'=>'DESC'),3,0);
   
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'commentaires' => $commentaires

        ]);
    }


}

