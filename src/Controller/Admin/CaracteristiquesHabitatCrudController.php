<?php

namespace App\Controller\Admin;

use App\Entity\CaracteristiquesHabitat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CaracteristiquesHabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CaracteristiquesHabitat::class;
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
