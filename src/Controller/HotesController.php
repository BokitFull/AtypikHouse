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
    
    #[Route('/', name: 'accueil_hote', methods: ['GET', 'POST'])]
    public function index(): Response
    {   
        return $this->render('hotes/index.html.twig', []);
    }

    #[Route('/habitats', name: 'hote_habitats', methods: ['GET', 'POST'])]
    public function habitats(Request $request, UtilisateursRepository $utilisateursRepository, AuthenticationUtils $authenticationUtils): Response
    {   
        $context = [];

        return $this->render('hotes/habitats.html.twig', $context);
    }
}
