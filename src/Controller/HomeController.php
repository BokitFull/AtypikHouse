<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
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
        //show only last three comments
        $commentaires = $repo->findBy(array(),array('id'=>'DESC'),3,0);
   
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'commentaires' => $commentaires

        ]);
    }


}


// use App\Entity\Utilisateurs;
// use App\Form\RegistrationFormType;
// use App\Form\LoginFormType;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Core\Security;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
// use Symfony\Component\HttpFoundation\Request;

// class HomeController extends AbstractController
// {
  
//     #[Route('/', name: 'home')]
//     public function index(): Response
//     {   
//         return $this->render('base.html.twig');
//     }
// }
