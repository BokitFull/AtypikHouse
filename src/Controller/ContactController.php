<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{
    //Index de la page de contact
    #[Route('/contact', name: 'app_contact')]
    public function index( Request $request ,  EntityManagerInterface $manager ): Response
    {
        $contact = new Contact() ; 
    
        //Création du formulaire et handle de la requête
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid())  
        { 
            //Enregistrement du form rempli et validé en base
            $manager->persist($contact);
            $manager->flush(); 

            unset($contact);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formContact' => $form->createView()
        ]);
    }
}
