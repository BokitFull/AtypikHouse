<?php

namespace App\Controller\Admin;

use App\Entity\CaracteristiquesTypeHabitat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CaracteristiquesTypeHabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CaracteristiquesTypeHabitat::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
