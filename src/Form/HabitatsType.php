<?php

namespace App\Form;

use App\Entity\Habitats;
use App\Entity\Equipements;
use App\Entity\TypeHabitats;
use App\Entity\InformationsPratiques;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\File;

class HabitatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('adresse')
            ->add('code_postal')
            ->add('ville')
            ->add('pays')
            ->add('est_disponible')
            ->add('description_title', TextType::class, [
                'label' => 'Titre description'
            ])
            ->add('description')
            // ->add('informations_supplementaires')
            ->add('prix')
            ->add('nombre_personnes_max')
            ->add('images', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => FileType::class,
                'entry_options' => [
                    'required' => false,
                    'empty_data' => 'No file',
                    'multiple' => true,
                    'attr' => ['class' => 'btn-outline-primary'],
                    'constraints' => [
                        new File([
                            'maxSize' => '5000k',
                            'mimeTypes' => [
                                'jpeg',
                                'jpg',
                                'png'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image',
                        ])
                    ],
                    'label' => 'Images',
                    'help' => 'Fichiers autorisés: jpg, jpeg, png (taille max: 5Mo)',
                    'help_attr' => ['class' => 'small']
                ]
            ])
            ->add('Equipements', EntityType::class, [
                'class' => Equipements::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('informations_pratiques', EntityType::class, [
                'class' => InformationsPratiques::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('TypeHabitat', EntityType::class, [
                'class' => TypeHabitats::class,
                'choice_label' => 'libelle',
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
