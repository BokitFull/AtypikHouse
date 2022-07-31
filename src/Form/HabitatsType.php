<?php

namespace App\Form;

use App\Entity\Habitats;
use App\Entity\Prestations;
use App\Entity\CaracteristiquesHabitat;
use App\Entity\ImagesHabitat;
use App\Entity\TypesHabitat;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\File;

class HabitatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('adresse')
            ->add('code_postal', TextType::class, [
                'label' => 'Code postal (2 chiffres)'
            ])
            // ->add('pays')
            ->add('est_actif')
            ->add('description')
            ->add('prix')
            ->add('nb_personnes')
            ->add('debut_disponibilite', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable'
                ])
            ->add('fin_disponibilite', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable'
                ])
            ->add('imagesHabitats', EntityType::class, [
                'class' => ImagesHabitat::class,
                'choice_label' => 'chemin',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('addImages', FileType::class, [
                'label' => 'Ajouter une image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // 'multiple' => true,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])

            // ->add('images', CollectionType::class, [
            //     'entry_type' => FileType::class,
            //     'entry_options' => [
            //         'required' => false,
            //         'empty_data' => 'No file',
            //         'multiple' => true,
            //         'attr' => ['class' => 'btn-outline-primary'],
            //         'constraints' => [
            //             new File([
            //                 'maxSize' => '5000k',
            //                 'mimeTypes' => [
            //                     'image/jpeg',
            //                     'image/jpg',
            //                     'image/png'
            //                 ],
            //                 'mimeTypesMessage' => 'Please upload a valid image',
            //             ])
            //         ],
            //         'label' => 'Images',
            //         'help' => 'Fichiers autorisés: jpg, jpeg, png (taille max: 5Mo)',
            //         'help_attr' => ['class' => 'small']
            //     ]
            // ])
            ->add('prestations', EntityType::class, [
                'class' => Prestations::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('caracteristiques', EntityType::class, [
                'class' => CaracteristiquesHabitat::class,
                'choice_label' => 'valeur',
                'multiple' => true,
                'expanded' => true,
            ])
            // ->add('ville', EntityType::class, [
            //     'class' => Ville::class,
            //     'choice_label' => 'nom',
            // ])
            // ->add('departement', EntityType::class, [
            //     'class' => Ville::class,
            //     'choice_label' => 'nom',
            // ])   
            // ->add('region', EntityType::class, [
            //     'class' => Ville::class,
            //     'choice_label' => 'nom', 
            // ])
            // ->add('pays', EntityType::class, [
            //     'class' => Ville::class,
            //     'choice_label' => 'nom',
            // ])
            ->add('type', EntityType::class, [
                'class' => TypesHabitat::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitats::class,
        ]);
    }
}
