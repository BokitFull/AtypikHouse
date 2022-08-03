<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionlegaleController extends AbstractController
{
    //Page des mentions légales
    #[Route('/mentionlegale', name: 'app_mentionlegale')]
    public function index(): Response
    {
        return $this->render('mentionlegale/index.html.twig', [
            'controller_name' => 'MentionlegaleController',
        ]);
    }
}
