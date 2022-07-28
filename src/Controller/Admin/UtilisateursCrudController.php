<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateurs;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class UtilisateursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateurs::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [IntegerField::new('id', 'ID'),
                EmailField::new('email', 'Email'),
                TextField::new('password', 'Password') ->hideOnIndex(),
                TextField::new('nom', 'Nom'),
                TextField::new('prenom', 'Prénom'),
                TelephoneField::new('telephone', 'Téléphone'),
                TextField::new('civilite', 'Civilité'),
                TextField::new('adresse', 'Adresse') ->hideOnIndex(),
                IntegerField::new('code_postal', 'Code Postal') ->hideOnIndex(),
                TextField::new('ville', 'Ville') ->hideOnIndex(),
                TextField::new('pays', 'Pays') ->hideOnIndex(),
                TextField::new('photo_profil', 'Photo de profil') ->hideOnIndex(),
                DateField::new('created_at', 'Créé le') ->hideOnIndex() ->hideWhenCreating() ->setFormTypeOption('disabled','disabled'),
                DateField::new('updated_at', 'Mis à jour le') ->hideOnIndex() ->hideWhenCreating() ->setFormTypeOption('disabled','disabled'),
                DateField::new('deleted_at', 'Supprimer le') ->hideOnIndex() ->hideWhenCreating() ->setFormTypeOption('disabled','disabled'),
                ChoiceField::new('roles', 'Roles')
                    ->setChoices([
                        'ROLE_USER' => 'ROLE_USER',
                        'ROLE_HOTE' => 'ROLE_HOTE',
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_SUSPENDED' => 'ROLE_SUSPENDED'])
                    ->allowMultipleChoices()
            ];
    }
    
}
