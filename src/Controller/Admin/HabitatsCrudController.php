<?php

namespace App\Controller\Admin;

use App\Entity\Habitats;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HabitatsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Habitats::class;
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
