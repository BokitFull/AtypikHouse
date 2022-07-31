<?php

namespace App\Controller\Admin;

use App\Entity\TypesPrestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypesPrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypesPrestation::class;
    }
}
