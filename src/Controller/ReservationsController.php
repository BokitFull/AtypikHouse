<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\Reservations;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{   
    #[Route('/reservations', name: 'reservations', methods: ['GET', 'POST'])]
    public function index(): Response
    {   
        return $this->render('utilisateurs/reservations.html.twig', []);
    }

    #[Route('/reservations/new', name: 'new_reservations', methods: ['GET', 'POST'])]
    public function new(): Response
    {   
        
        return $this->render('utilisateurs/reservations.html.twig', []);
    }

    #[Route('/reservations/{id}', name: 'reservations_detail', methods: ['GET', 'POST'])]
    public function detail(Request $request, Reservations $reservation, Commentaires $commentaires, CommentairesRepository $commentairesRepository): Response
    {   

        $context['reservation'] = $reservation;
        $duree = $reservation->getDateDebut()->diff($reservation->getDateFin());
        $context['duree'] = $duree->format('%a');
        $form = $this->createForm(CommentairesType::class, $commentaires);
        $form->handleRequest($request);
        $context['form'] = $form;

        // dump($form->getErrors());die;
        if ($form->isSubmitted() && $form->isValid()) {
            
            $commentairesRepository->add($commentaires, true);
            return $this->redirectToRoute('reservations', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('utilisateurs/reservations_detail.html.twig', $context);
    }
}
