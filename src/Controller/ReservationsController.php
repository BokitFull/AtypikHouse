<?php

namespace App\Controller;

use App\Entity\Reservations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/reservations/{id}', name: 'reservations_detail', methods: ['GET'])]
    public function detail(Reservations $reservation): Response
    {   $context['reservation'] = $reservation;
        return $this->render('utilisateurs/reservations_detail.html.twig', $context);
    }
}
