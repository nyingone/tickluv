<?php

namespace App\Form;

use App\Entity\BookingOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Optionsresolver\OptionsResolver;


class BookingData extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expectedDate', DateType::class, array('attr' => array('class' => 'form-control')))
            ->add('partTimeCode', NumberType::class, array('attr' => array('class' => 'form-control')))
            ->add('ticketCount', NumberType::class, array('attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingOrder::class,
        ]);
    }

    
}