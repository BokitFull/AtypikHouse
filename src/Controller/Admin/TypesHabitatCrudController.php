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
}
