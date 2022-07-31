<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
use App\Entity\Habitats;
use App\Entity\TypesHabitat;
use App\Form\BecomeHostType;
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

    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine-> getRepository(Commentaires::class); 
        $repoHabitat = $doctrine-> getRepository(Habitats::class); 
        $repoType = $doctrine-> getRepository(TypesHabitat::class); 
        //show only last three comments
        $commentaires = $repo->findBy(array(),array('id'=>'DESC'),3,0);
        //
        $departement = $repoHabitat->findAll();
        $nombreDepersonne = $repoHabitat->findAll( array('nombrePersonnesMax' => 'DESC'));
        $typeHebergement = $repoType->findAll();


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'commentaires' => $commentaires ,
            'habitats' => $departement ,
            'habitats' =>  $nombreDepersonne ,
            'TypesHabitat' =>  $typeHebergement 
        ]);
    }

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

