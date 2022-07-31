<?php

namespace App\Controller;

use App\Entity\Abonner;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
use App\Entity\Habitats;
use App\Entity\TypesHabitat;
use App\Form\BecomeHostType;
use App\Form\AbonnerType as FormAbonnerType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;


class HomeController extends AbstractController
{
    public function __construct(Security $security)
    {
    $this->security = $security;
    }

    //Page d'accueil
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine , Request $request , EntityManagerInterface $manager): Response
    {
        $repo = $doctrine-> getRepository(Commentaires::class); 
        $repoHabitat = $doctrine-> getRepository(Habitats::class); 
        $repoType = $doctrine-> getRepository(TypesHabitat::class); 

        //Trouve les 3 derniers commentaires d'un habitat
        $commentaires = $repo->findBy(array(),array('id'=>'DESC'),3,0);

        $departement = $repoHabitat->findAll();
        $typeHebergement = $repoType->findAll();

        $abonner = new Abonner() ;
    
        $form = $this->createForm(FormAbonnerType::class, $abonner);
        $form->handleRequest($request);

        //Enregistrement du formulaire d'abonnement à la newsletter
        if ($form->isSubmitted() && $form->isValid())  
        { 
            $manager->persist($abonner);
            $manager->flush();
            
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'commentaires' => $commentaires ,
            'habitats' => $departement ,
            'TypesHabitat' =>  $typeHebergement ,
            'formAbonner' => $form->createView()
        ]);
    }

    //Page de changement de rôle entre utilisateur et hôte
    #[Route('/devenir_hote', name: 'devenir_hote', methods: ['POST'])]
    public function hoteAccueil(Request $request, EntityManagerInterface $entityManager, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator): Response
    {   
        $form = $this->createForm(BecomeHostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $user = $this->security->getUser();
            $user->setRoles(['ROLE_HOTE']);
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash(
                'success', 'Vous êtes devenu un hôte, vous pouvez maintenant ajouter des habitats en allant sur votre profil'
            );
            
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            
            return $this->redirectToRoute('accueil_utilisateur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('home' ,['host_form' => $form]);
    }
}

