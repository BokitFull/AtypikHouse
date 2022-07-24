<?php

namespace App\Form;

use App\Entity\Habitats;
use App\Entity\Prestations;
use App\Entity\TypesHabitat;
use App\Entity\Ville;
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
            ->add('titre')
            ->add('adresse')
            ->add('code_postal')
            ->add('pays')
            ->add('est_valide')
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('description')
            // ->add('informations_supplementaires')
            ->add('prix')
            ->add('nb_personnes')
            // ->add('images', CollectionType::class, [
            //     'allow_add' => true,
            //     'allow_delete' => true,
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
            //                     'jpeg',
            //                     'jpg',
            //                     'png'
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
