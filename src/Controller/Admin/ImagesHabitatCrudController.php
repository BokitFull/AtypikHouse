<?php

namespace App\Controller\Admin;

use App\Entity\ImagesHabitat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImagesHabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImagesHabitat::class;
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
