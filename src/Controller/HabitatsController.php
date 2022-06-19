<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Form\HabitatsType;
use App\Repository\HabitatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/habitats')]
class HabitatsController extends AbstractController
{
    #[Route('/', name: 'app_habitats_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, HabitatsRepository $habitatsRepository): Response
    {
        if (isset($_GET["dep"])) {
            
            // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
            $donnees = $habitatsRepository->findBy(array('code_postal' => $_GET["dep"]));
            
            $habitats = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );
            
            return $this->render('habitats/index.html.twig', [
                'habitats' => $habitats,
            ]);
        } else {

            // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
            $donnees = $habitatsRepository->findAll();

            $habitats = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );

            return $this->render('habitats/index.html.twig', [
                'habitats' => $habitats,
            ]);
        }
    }

    #[Route('/new', name: 'app_habitats_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HabitatsRepository $habitatsRepository): Response
    {
        $habitat = new Habitats();
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $habitatsRepository->add($habitat, true);

            return $this->redirectToRoute('app_habitats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitats/new.html.twig', [
            'habitat' => $habitat,
            'form' => $form,
        ]);
    }

    #[Route('/calendar', name: 'habitat_calendar', methods: ['GET'])]
    public function calendar(): Response
    {   
        $context = [];
        $habitats = $this->getUser()->getHabitats();
        $reservations_date = [];
        foreach($habitats as $habitat){
            $dates = [];
            foreach($habitat->getReservations() as $reservation){
                    $dates[$reservation->getId()] = [
                        'start'=> $reservation->getDateDebut()->format('Y-m-d'), 
                        'end'=>  $reservation->getDateFin()->format('Y-m-d')
                    ];
                }
            $reservations_date[$habitat->getId()] = $dates;
        }
        $context['reservations_date'] = $reservations_date;
        return $this->render('habitats/calendar.html.twig', $context);
    }
    
    #[Route('/{id}', name: 'habitats_detail', methods: ['GET'])]
    public function show(Habitats $habitat): Response
    {   
        $context = [];
        
        return $this->render('habitats/show.html.twig', $context);
    }

    #[Route('/{id}/edit', name: 'edit_habitat', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habitats $habitat, HabitatsRepository $habitatsRepository): Response
    {
        $context = [];

        $form = $this->createForm(Habitats1Type::class, $habitat);
        $context['form'] = $form;
        $context['habitat'] = $habitat;
        if ($form->isSubmitted() && $form->isValid()) {
            $habitatsRepository->add($habitat, true);

            return $this->redirectToRoute('habitats_detail', ['id'=>  $habitat->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitats/edit.html.twig', $context);
    }

    #[Route('/{id}', name: 'app_habitats_delete', methods: ['POST'])]
    public function delete(Request $request, Habitats $habitat, HabitatsRepository $habitatsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $habitat->getId(), $request->request->get('_token'))) {
            $habitatsRepository->remove($habitat, true);
        }

        return $this->redirectToRoute('app_habitats_index', [], Response::HTTP_SEE_OTHER);
    }
}
