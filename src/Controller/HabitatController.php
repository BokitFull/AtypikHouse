<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\HabitatFormType;
use App\Repository\HabitatsRepository;
use App\Repository\NotesRepository;
use App\Repository\CommentairesRepository;

class HabitatController extends AbstractController
{
    public function __construct(HabitatsRepository $repository, CommentairesRepository $commsRepository) {
        $this->repository = $repository;
        $this->commsRepository = $commsRepository;
    }


    #[Route('/habitat/{id}', name: 'habitat.show')]
    public function show($id): Response
    {
        $habitat = $this->repository->find($id);
        $commentaires = $this->commsRepository->findByHabitat($habitat);

        return $this->render('habitat/show.html.twig', [
            'controller_name' => 'HabitatController',
            'habitat' => $habitat,
            'commentaires' => $commentaires,
        ]);
    }
}
