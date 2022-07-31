<?php

namespace App\Controller\Admin;

use App\Entity\Prestations;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PrestationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prestations::class;
    }
}
