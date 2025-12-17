<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('moreInformation', TextareaType::class, [
                'label' => 'Informations complémentaires (optionnel)',
                'required' => false,
                'help' => 'Exemples : accès difficile, présence d’animaux, contraintes horaires, informations utiles pour l’intervention.',
            ])

            ->add('location_type', ChoiceType::class, [
                'label' => 'Type de lieu',
                'choices' => Booking::LOCATION_TYPES,
                'placeholder' => 'Sélectionnez un type de lieu',
            ])
            ->add('urgency_rank', ChoiceType::class, [
                'label' => 'Niveau d\'urgence',
                'choices' => Booking::URGENCY_TYPES,
                'placeholder' => 'Sélectionnez le niveau d\'urgence',
            ])
            ->add('target_type', ChoiceType::class, [
                'label' => 'Cible à exorciser',
                'choices' => Booking::TARGET_TYPES,
                'placeholder' => 'Sélectionnez la cible',
            ])
            ->add('objective_type', ChoiceType::class, [
                'label' => 'Objectif de l\'intervention',
                'choices' => Booking::OBJECTIVE_TYPES,
                'placeholder' => 'Sélectionnez l\'objectif',
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Définir le rendez-vous',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'validation_groups' => ['step1']
        ]);
    }
}