<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\EditUserType;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/profil')]
class UtilisateursController extends AbstractController
{   
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    #[Route('/', name: 'accueil_utilisateur', methods: ['GET'])]
    public function home(): Response
    {   
        $context['utilisateur'] = $this->getUser();
        return $this->render('utilisateurs/index.html.twig', $context);
    }

    #[Route('/informations_personnelles', name: 'informations_personnelles', methods: ['GET'])]
    public function informations_personelles(): Response
    {  
        return $this->render('utilisateurs/informations_personnelles.html.twig');
    }

    #[Route('/reservations', name: 'reservation_utilisateur', methods: ['GET', 'POST'])]
    public function reservations(Request $request, UtilisateursRepository $utilisateursRepository): Response
    {   
        $context['utilisateur'] = $this->getUser();

        return $this->render('utilisateurs/reservations.html.twig', $context);
    }

    #[Route('/{id}/edit', name: 'informations_personnelles', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateurs $utilisateur, UtilisateursRepository $utilisateursRepository): Response
    {
        $form = $this->createForm(EditUserType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $_FILES["edit_user"];
            $utilisateursRepository->add($utilisateur, true);
            move_uploaded_file($image['tmp_name']['image'],"../public/images/uploads/".$utilisateur->getID().'.jpg');

            return $this->redirectToRoute('accueil_utilisateur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateurs/informations_personnelles.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateurs $utilisateur, UtilisateursRepository $utilisateursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateursRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
