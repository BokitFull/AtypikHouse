<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Utilisateurs;
use App\Form\LoginFormType;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{   
    //Inscription d'un utilisateur
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateurs();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator, 
                $request
            );
        }

        // return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
    }

    //Login de l'utilisateur
    #[Route(path: '/login', name: 'login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {   
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $registerForm = $this->createForm(RegistrationFormType::class, new Utilisateurs())->createView();
        $loginForm = $this->createForm(LoginFormType::class, new Utilisateurs())->createView();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'register_form' => $registerForm,
            'login_form' => $loginForm

        ]);
    }

    //Formulaire d'authentification pour le login/inscription
    
    public function authentication_form(Request $request ,AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $request->getSession()->get(Security::LAST_USERNAME, '') ? $authenticationUtils->getLastUsername() : '';
        $registerForm = $this->createForm(RegistrationFormType::class, new Utilisateurs())->createView();
        $loginForm = $this->createForm(LoginFormType::class, new Utilisateurs())->createView();
        return $this->render('security/_authentication_forms.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'register_form' => $registerForm,
            'login_form' => $loginForm

        ]);
    }
    
    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
}
