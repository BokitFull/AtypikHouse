<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Entity\Habitats;
use App\Form\RegistrationFormType;
use App\Form\LoginFormType;
use App\Form\HabitatsType;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/hote')]
class HotesController extends AbstractController
{   
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    #[Route('/', name: 'hote_presentation', methods: ['GET', 'POST'])]
    public function hotePresentation(Request $request, UtilisateursRepository $utilisateursRepository, AuthenticationUtils $authenticationUtils): Response
    {   
        return $this->render('hotes/presentation.html.twig', []);
    }
    
    // #[Route('/home', name: 'hote_accueil', methods: ['GET', 'POST'])]
    // public function hoteAccueil(Request $request, UtilisateursRepository $utilisateursRepository, AuthenticationUtils $authenticationUtils): Response
    // {   
    //     $context = [];

    //     if($request->isMethod('POST')){
    //         if($this->getUser()){
    //             $this->getUser()->setRoles(['ROLE_HOTE']);
    //         }
    //     }

    //     return $this->render('hotes/accueil.html.twig', $context);
    // }

    #[Route('/habitats', name: 'hote_habitats', methods: ['GET', 'POST'])]
    public function habitats(Request $request, UtilisateursRepository $utilisateursRepository, AuthenticationUtils $authenticationUtils): Response
    {   
        $context = [];

        return $this->render('hotes/habitats.html.twig', $context);
    }
}
