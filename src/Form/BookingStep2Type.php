<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\service;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sheduledAt', DateTimeType::class, [
                'label' => 'Date et horaire'
            ])

            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])

            ->add('postal_code', TextType::class, [
                'label' => 'Code postal'
            ])

            ->add('customer', CustomerType::class, [
                'label' => false,
                'mapped' => true
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider et obtenir un devis',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'validation_groups' => ['step2']
        ]);
    }
}