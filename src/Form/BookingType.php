<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sheduledAt')
            ->add('address', TextType::class)
            ->add('postal_code')
            ->add('moreInformation')

            ->add('customer', CustomerType::class, [
                'label' => false,
                'mapped' => true
                // 'choice_label' => 'id',
            ])

            ->add('service', EntityType::class, [
                'class' => service::class,
                'choice_label' => 'id',
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Réserver',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}