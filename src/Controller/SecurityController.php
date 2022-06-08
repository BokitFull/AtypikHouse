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
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    // #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateurs();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new DateTimeImmutable('now'));
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $context = [];
        // $context['error'] = $authenticationUtils->getLastAuthenticationError();
        // // last username entered by the user
        // $context['last_username'] = $authenticationUtils->getLastUsername();
        // $utilisateur = new Utilisateurs();
        // $context['register_form'] = $this->createForm(RegistrationFormType::class, $utilisateur)->createView();
        // $context['login_form'] = $this->createForm(LoginFormType::class, $utilisateur)->createView();

        return $this->render('security/login.html.twig', $context);
    }

    public function authentication_form(AuthenticationUtils $authenticationUtils): Response
    {
        $context['error'] = $authenticationUtils->getLastAuthenticationError();
        $context['last_username'] = $authenticationUtils->getLastUsername();
        $utilisateur = new Utilisateurs();
        $context['register_form'] = $this->createForm(RegistrationFormType::class, $utilisateur)->createView();
        $context['login_form'] = $this->createForm(LoginFormType::class, $utilisateur)->createView();

        return $this->render('security/_authentication_forms.html.twig', $context);
    }
    

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    
}
