<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom *'
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom *'
            ])
            ->add('Email', TextType::class, [
                'label' => 'Email *'
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone *'
            ])
            ->add('message' , TextareaType::class, [
                'label' => 'Message *'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
