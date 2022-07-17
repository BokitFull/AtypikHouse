<?php

namespace App\Controller\Admin;

use App\Entity\CaracteristiquesHabitat;
use App\Entity\CaracteristiquesTypeHabitat;
use App\Entity\Habitats;
use App\Entity\Prestations;
use App\Entity\Reservations;
use App\Entity\TypesHabitat;
use App\Entity\TypesPrestation;
use App\Entity\Utilisateurs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(UtilisateursCrudController::class)->generateUrl();
        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AtypikHouse');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'homepage');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-map-marker-alt', Utilisateurs::class);
        yield MenuItem::linkToCrud('Habitats', 'fas fa-comments', Habitats::class);
        yield MenuItem::linkToCrud('TypesHabitat', 'fas fa-map-marker-alt', TypesHabitat::class);
        yield MenuItem::linkToCrud('CaracteristiquesTypeHabitat', 'fas fa-map-marker-alt', CaracteristiquesTypeHabitat::class);
        yield MenuItem::linkToCrud('CaracteristiquesHabitat', 'fas fa-map-marker-alt', CaracteristiquesHabitat::class);
        yield MenuItem::linkToCrud('TypesPrestation', 'fas fa-map-marker-alt', TypesPrestation::class);
        yield MenuItem::linkToCrud('Prestations', 'fas fa-map-marker-alt', Prestations::class);
        yield MenuItem::linkToCrud('Reservations', 'fas fa-map-marker-alt', Reservations::class);
    }
}
