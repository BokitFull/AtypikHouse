<?php

namespace App\Controller;

use App\Entity\Abonner;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commentaires;
use App\Entity\Habitats;
use App\Entity\TypesHabitat;
use App\Form\AbonnerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            $abonner->setCreatedAt(new \DateTimeImmutable());

        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'commentaires' => $commentaires ,
            'habitats' => $departement ,
            'TypesHabitat' =>  $typeHebergement ,
            'formAbonner' => $form->createView()
        ]);
    }

}

