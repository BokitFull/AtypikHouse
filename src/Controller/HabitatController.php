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
    public function __construct(HabitatsRepository $repository, 
    NotesRepository $notesRepository, CommentairesRepository $commsRepository) {
        $this->repository = $repository;
        $this->notesRepository = $notesRepository;
        $this->commsRepository = $commsRepository;
    }

    #[Route('/habitats', name: 'habitat.index')]
    public function index(): Response
    {
        return $this->render('habitat/index.html.twig', [
            'controller_name' => 'HabitatController',
        ]);
    }

    #[Route('/habitat/{id}', name: 'habitat.show')]
    public function show($id): Response
    {
        $habitat = $this->repository->find($id);
        $notes = $this->notesRepository->findNotesMoyennesByHabitat($habitat);
        $commentaires = $this->commsRepository->findBy(array(), array('id' => 'ASC'), 3);

        return $this->render('habitat/show.html.twig', [
            'controller_name' => 'HabitatController',
            'habitat' => $habitat,
            'notes' => $notes,
            'commentaires' => $commentaires,
        ]);
    }
}