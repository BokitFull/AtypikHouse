<?php

namespace App\Controller\Admin;

use App\Entity\TypesHabitat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypesHabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypesHabitat::class;
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
