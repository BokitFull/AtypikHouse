<?php

namespace App\Form;

use App\Entity\Habitats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Habitats1Type extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitats::class,
        ]);
    }
}