<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {   
        return $this->render('base.html.twig');
=======
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	public function __construct() 
	{
		
	}
	
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
>>>>>>> ddcb4bc36735221908ff4a0f6530cfb7a1ec4e66
    }
}
