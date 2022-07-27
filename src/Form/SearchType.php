<?php

namespace App\Form;

use App\Entity\Habitats;
use App\Repository\HabitatsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function __construct(HabitatsRepository $habitatsRepository) {
        $this->habitatsRepository = $habitatsRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $destinations = array_column($this->typesHabitatRepository->getDestinations(), 'nom', 'id');
        $builder
            ->add('destination', ChoiceType::class, [
                  'required' => false,
                  'multiple' => false,
                  'expanded' => false,
                  'choices' => array_combine(array_values($typesHabitat), array_keys($typesHabitat)),
                ])
            ->add('hebergement')
            ->add('nb_personnes')
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Habitats::class,
        ]);
    }
}
