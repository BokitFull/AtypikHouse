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
use Symfony\Component\Finder\Finder;

#[Route('/utilisateurs')]
class UtilisateursController extends AbstractController
{   
    private $security;
    private $finder;

    public function __construct(Security $security)
    {
       $this->security = $security;
       $this->finder = new Finder();
    }

    //Page de profil utilisateur
    #[Route('/', name: 'accueil_utilisateur', methods: ['GET'])]
    public function home(): Response
    {   
        $context['utilisateur'] = $this->getUser();

        $this->finder->in("images/uploads/users/")->files()->name($this->getUser()->getId() . ".jpg");
        if($this->finder->hasResults()) {
            foreach($this->finder as $file) {
                if(file_exists($file)) {
                    $context["imageExists"] = true;
                }
                else {
                    $context["imageExists"] = false;
                }
                break;
            }
        }

        return $this->render('utilisateurs/index.html.twig', $context);
    }

    //Page d'édition des informations d'un utilisateur
    #[Route('/{id}/edit', name: 'informations_personnelles', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateurs $utilisateur, UtilisateursRepository $utilisateursRepository): Response
    {
        // Securiser Utilisateur 
        $currentUser = $this->security->getUser();
        if ($currentUser->getId() != $utilisateur->getId() )
        { 
            return $this->redirectToRoute('informations_personnelles', ["id" => $currentUser->getId()], Response::HTTP_SEE_OTHER);

        }
   

        $form = $this->createForm(EditUserType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            //Gestion de l'image de profil utilisateur
            $image = $_FILES["edit_user"];
            $utilisateursRepository->add($utilisateur, true);

            move_uploaded_file($image['tmp_name']['image'],"../public/images/uploads/users/".$utilisateur->getID().'.jpg');

            return $this->redirectToRoute('accueil_utilisateur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateurs/informations_personnelles.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    //Suppression d'un utilisateur
    #[Route('/{id}', name: 'app_utilisateurs_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateurs $utilisateur, UtilisateursRepository $utilisateursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateursRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
