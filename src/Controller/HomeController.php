<?php

namespace App\Controller;

use App\Entity\Abonner;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
use App\Entity\Habitats;
use App\Entity\TypesHabitat;
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
    public function index(ManagerRegistry $doctrine , Request $request , EntityManagerInterface $manager): Response
    {
        $repo = $doctrine-> getRepository(Commentaires::class); 
        $repoHabitat = $doctrine-> getRepository(Habitats::class); 
        $repoType = $doctrine-> getRepository(TypesHabitat::class); 
        //show only last three comments
        $commentaires = $repo->findBy(array(),array('id'=>'DESC'),3,0);
        //
        $departement = $repoHabitat->findAll();
        $typeHebergement = $repoType->findAll();

        $abonner = new Abonner() ; 
    
        $form = $this->createForm(AbonnerType::class, $abonner);
        $form->handleRequest($request);


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

    #[Route('/changer_role', name: 'changer_role', methods: ['GET'])]
    public function hoteAccueil(Request $request, EntityManagerInterface $entityManager, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator): Response
    {   
        if($this->getUser()){
            $user = $this->security->getUser();
            $userRoles = [
                'hote' => [
                    'role' => ['ROLE_HOTE'],
                    'message' => 'Vous êtes devenu un hôte, vous pouvez maintenant ajouter des habitats en allant sur votre profil'
                    ], 
                'user' => [
                    'role' => ['ROLE_USER'],
                    'message' => 'Vous êtes redevenu un utilisateur, vous pouvez maintenant effectuer des réservations']
                ];
            $user->setRoles($userRoles[$request->query->get('type')]['role']);
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash(
                'success', $userRoles[$request->query->get('type')]['message']
            );
            
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        return $this->redirectToRoute('home');
    }
}

