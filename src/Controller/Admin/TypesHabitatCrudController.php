<?php

namespace App\Controller\Admin;

use App\Entity\TypesHabitat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Proxies\__CG__\App\Entity\TypeHabitats;


class TypesHabitatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypesHabitat::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $typesHabitat = new TypesHabitat();
        return $typesHabitat;
    }
    
    // public function configureFields(string $pageName): iterable
    // {
    //     return ['id', 'nom', 'description', 'created_at', 'updated_at', 'deleted_at'
    //         // IdField::new('id'),
    //         // TextField::new('title'),
    //         // TextEditorField::new('description'),
    //     ];
    // }
    
}
