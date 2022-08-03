<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SEOController extends AbstractController
{

    //Page d'accueil
    #[Route('/robots.txt', name: 'app_robos')]
    public function robots(): Response
    {
        $response = new Response($this->renderView('robots.html.twig'));
        $response->headers->set('Content-Type', 'text/txt');
        return $response;
    }
    
    //Page d'accueil
    #[Route('/sitemap.xml', name: 'app_sitemap')]
    public function sitemap(): Response
    {
        $response = new Response($this->renderView('sitemap.html.twig'));
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
    
}