<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Form\HabitatsType;
use App\Repository\HabitatsRepository;
use App\Repository\TypeHabitatsRepository;
use App\Repository\CommentairesRepository;
use App\Repository\ReservationsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FileUploader;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/habitats')]
class HabitatsController extends AbstractController
{

    
    public function __construct(HabitatsRepository $repository, CommentairesRepository $commsRepository) {
        $this->repository = $repository;
        $this->commsRepository = $commsRepository;
    }

    // #[Route('/new', name: 'new_habitat', methods: ['GET', 'POST'])]
    // public function new(Request $request, HabitatsRepository $habitatsRepository, FileUploader $fileUploader): Response
    // {
    //     $context = [];
        
    //     $habitat = new Habitats();
    //     $form = $this->createForm(HabitatsType::class, $habitat);
    //     $form->handleRequest($request);
    //     $context['form'] = $form;
    //     $context['habitat'] = $habitat;
        
    //     $images = $form->get('images')->getData();
    //     var_dump($images);
        
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $images = $form->get('images')->getData();

    //         foreach ($images as $key => $value) {
    //             var_dump($value);
    //             $uploader->upload($value);
    //             $habitat->addImage($value);
    //         }

    //         $habitat->setCreatedAt(new \DateTimeImmutable('now'));
    //         $habitatsRepository->add($habitat, true);

    //         return $this->redirectToRoute('hote_habitats', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('habitats/new.html.twig', $context);
    // }


    #[Route('/', name: 'habitats_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, HabitatsRepository $habitatsRepository, TypeHabitatsRepository $typeHabitatsRepository): Response
    {
        // $test = urldecode("http://127.0.0.1:8000/habitats/?code_postal=51&type_habitat_id=24&nombre_personnes_max=4&daterange=07%2F07%2F2022+-+07%2F15%2F2022");
        // var_dump($test);die;
            $donnees = $habitatsRepository->findByHabitats($_GET);

            $dep = $habitatsRepository->findByDep();

            $types = $typeHabitatsRepository->findByTypes();

            $params = $_GET;
            $habitats = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );
            
            return $this->render('habitats/index.html.twig', [
                'habitats' => $habitats,
                'dep' => $dep,
                'types' => $types,
                'params' => $params,
            ]);
    }

    #[Route('/calendar', name: 'habitat_calendar', methods: ['GET'])]
    public function calendar(ReservationsRepository $reservationsRepository): Response
    {   
        $context = [];
        $habitats = $this->getUser()->getHabitats()->toArray();
        $habitats = array_map(function($x) {return $x->getId();}, $habitats);
        $current_date = new DateTime();
        $current_date = $current_date->format('Y-m-d');
        $reservations_date = $reservationsRepository->getReservationsByDate([
            'year' => explode('-', $current_date)[0],
            'month' => explode('-', $current_date)[1],
            'id' => implode(",", $habitats)
        ]);
        
        $context['reservations_date'] = $reservations_date;
        return $this->render('habitats/calendar.html.twig', $context);
    }
    
    #[Route('/{id}', name: 'habitats_detail', methods: ['GET'])]
    public function show(Habitats $habitat): Response
    {
        $commentaires = $this->commsRepository->findByHabitat($habitat);
        $notes = $this->commsRepository->findNotesMoyennesByHabitat($habitat);

        return $this->render('habitats/show.html.twig', [
            'controller_name' => 'HabitatsController',
            'habitat' => $habitat,
            'commentaires' => $commentaires,
            'notes' => $notes,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit_habitat', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habitats $habitat, HabitatsRepository $habitatsRepository, FileUploader $uploader): Response
    {
        $context = [];

        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);
        $context['form'] = $form;
        $context['habitat'] = $habitat;
        
        // $images = $form->get('images')->getData();
        // var_dump($images);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();

            foreach ($images as $key => $value) {
                var_dump($value);
                // $uploader->upload($value);
                // $habitat->addImage($value);
            }

            $habitatsRepository->add($habitat, true);

            return $this->redirectToRoute('hote_habitats', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitats/edit.html.twig', $context);
    }

    #[Route('/{id}', name: 'delete_habitat', methods: ['POST'])]
    public function delete(Request $request, Habitats $habitat, HabitatsRepository $habitatsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $habitat->getId(), $request->request->get('_token'))) {
            // $habitatsRepository->remove($habitat, true);
        }

        return $this->redirectToRoute('hote_habitats', [], Response::HTTP_SEE_OTHER);
    }
    
}
