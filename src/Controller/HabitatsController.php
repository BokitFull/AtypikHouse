<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Entity\Departements;
use App\Entity\Habitats;
use App\Entity\Region;
use App\Entity\Pays;
use App\Entity\ImagesHabitat;
use App\Form\HabitatsType;
use App\Repository\HabitatsRepository;
use App\Repository\ImagesHabitatRepository;
use App\Repository\CommentairesRepository;
use App\Repository\VilleRepository;
use App\Repository\DepartementsRepository;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use App\Repository\ReservationsRepository;
use App\Repository\TypesHabitatRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FileUploader;

use Symfony\Component\Security\Core\Security;

#[Route('/habitats')]
class HabitatsController extends AbstractController
{
    private $security;

    public function __construct(HabitatsRepository $repository, CommentairesRepository $commsRepository, ImagesHabitatRepository $imagesRepository,
    PaysRepository $paysRepository, RegionRepository $regionRepository, DepartementsRepository $departementsRepository, VilleRepository $villeRepository,
    Security $security) {
        $this->repository = $repository;
        $this->commsRepository = $commsRepository;
        $this->regionRepository = $regionRepository;
        $this->departementsRepository = $departementsRepository;
        $this->paysRepository = $paysRepository;
        $this->villeRepository = $villeRepository;
        $this->security = $security;
        $this->imagesRepository = $imagesRepository;
    }

    //Création des pays/régions/départements/villes à ajouter en base
    public function createLocation(Request $request){
        $pays = new Pays();
        $region = new Region();
        $departements = new Departements();
        $ville = new Ville();

        if(!$this->paysRepository->findBy(['nom' => 'France'])) {
            $pays->setNom("France");
            $this->paysRepository->add($pays, true);
        }

        $adresse = explode(';', $request->request->get('adresse'));

        if(str_contains($request->request->get('adresse'), ";")) {
            if(!$this->regionRepository->findBy(['nom' => $adresse[3]])){
                $region->setNom($adresse[3]);
                $region->setPays($this->paysRepository->findBy(['nom' => 'France'])[0]);
                $this->regionRepository->add($region);
            }
        }

        if(str_contains($request->request->get('adresse'), ";")) {
            if(!$this->departementsRepository->findBy(['nom' => $adresse[2]])){
                $departements->setNom($adresse[2]);
                $departements->setRegion($region);
                $this->departementsRepository->add($departements);
            }
        }

        if(str_contains($request->request->get('adresse'), ";"))  {
            if(!$this->villeRepository->findBy(['nom' => $adresse[0]])){
                $ville->setNom($adresse[0]);
                $ville->setDepartements($departements);
                $this->villeRepository->add($ville);
            }
        }

        return;
    }

    //Nouvel habitat
    #[Route('/new', name: 'new_habitat', methods: ['GET', 'POST'])]
    public function new(Request $request, HabitatsRepository $habitatsRepository, FileUploader $fileUploader): Response
    {
        $context = [];
        
        //Création du formulaire + handle de la requête
        $habitat = new Habitats();
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        $context['form'] = $form;
        $context['habitat'] = $habitat;
        // dump($form->getErrors()); die;
        if ($form->isSubmitted() && $form->isValid()) {
            
            $utilisateur = $this->getUser();

            //Définition des valeurs par défaut pour l'habitat
            
            $habitat->setEstValide(false);
            $habitat->setUtilisateur($utilisateur);
            $habitatsRepository->add($habitat, true);

            //Ajout des images à l'habitat
            if($_FILES["habitats"]) {

                $file = $_FILES["habitats"];
                $name = $habitat->getId() . "_" . $file["name"]["addImages"];
                move_uploaded_file($file["tmp_name"]["addImages"],"../public/images/uploads/habitats/". $name);
                
                $count = 0;
                for($count = 0; $count < count($habitat->getImagesHabitats()) ; $count++) ;
                
                $image = new ImagesHabitat();
                $image->setChemin($name);
                $image->setHabitat($habitat);
                $image->setPosition($count + 1);
                $image->setHabitat($habitat);
                
                $this->imagesRepository->add($image, true);
                
                // $habitat->addImagesHabitat($image);
            }

            return $this->redirectToRoute('hote_habitats', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitats/new.html.twig', $context);
    }

    //Liste des habitats
    #[Route('/', name: 'habitats_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, TypesHabitatRepository $typesHabitatsRepository,  HabitatsRepository $habitatsRepository): Response
    {       
            $donnees = $habitatsRepository->findByHabitats(array_filter($_GET));
            $dep = $habitatsRepository->findByDep();
            $types = $typesHabitatsRepository->findByTypes();

            //Pagination
            $habitats = $paginator->paginate(
                $donnees, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                6 // Nombre de résultats par page
            );
            
            return $this->render('habitats/index.html.twig', [
                'habitats' => $habitats,
                'dep' => $dep,
                'types' => $types,
            ]);
    }

    //Calendrier de disponibilité des habitats
    #[Route('/calendar', name: 'habitat_calendar', methods: ['GET'])]
    public function calendar(ReservationsRepository $reservationsRepository): Response
    {   
        $context = [];
        $habitats = $this->security->getUser()->getHabitats()->toArray();
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
    
    //Détails des habitats
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

    //Modification d'un habitat
    #[Route('/{id}/edit', name: 'edit_habitat', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habitats $habitat, HabitatsRepository $habitatsRepository, FileUploader $uploader): Response
    {
        $context = [];

        //Création du formulaire + handle de la requête
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        $context['form'] = $form;
        $context['habitat'] = $habitat;

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createLocation($request);

            //Ajout des nouvelles images
            if($_FILES["habitats"]) {

                $file = $_FILES["habitats"];
                $name = $habitat->getId() . "_" . $file["name"]["addImages"];
                move_uploaded_file($file["tmp_name"]["addImages"],"../public/images/uploads/habitats/". $name);
                
                $count = 0;
                for($count = 0; $count < count($habitat->getImagesHabitats()) ; $count++) ;
                
                $image = new ImagesHabitat();
                $image->setChemin($name);
                $image->setHabitat($habitat);
                $image->setPosition($count + 1);
                $this->imagesRepository->add($image, true);
                
                $habitat->addImagesHabitat($image);
            }

            $habitatsRepository->add($habitat, true);

            return $this->redirectToRoute('hote_habitats', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitats/edit.html.twig', $context);
    }

    //Delete d'un habitat
    #[Route('/{id}', name: 'delete_habitat', methods: ['POST'])]
    public function delete(Request $request, Habitats $habitat, HabitatsRepository $habitatsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $habitat->getId(), $request->request->get('_token'))) {
            // $habitatsRepository->remove($habitat, true);
        }

        return $this->redirectToRoute('hote_habitats', [], Response::HTTP_SEE_OTHER);
    }
    
}