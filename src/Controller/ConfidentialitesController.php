<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfidentialitesController extends AbstractController
{
    #[Route('/confidentialites', name: 'app_confidentialites')]
    public function index(): Response
    {
        return $this->render('confidentialites/index.html.twig', [
            'controller_name' => 'ConfidentialitesController',
        ]);
    }

    public function content(): Response
    {
        return $this->render('confidentialites/_content.html.twig', []);
    }
}
