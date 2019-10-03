<?php

namespace App\Form;

use App\Form\BookingOrderType;
use App\Form\CustomerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expectedDate', DateType::class, array('attr' => array('class' => 'form-control')))
           
       
        ;
        $builder->add('visitors', CollectionType::class, [
            'entry_type' => BookingOrderType::class,
            'entry_options' => ['label' => false],
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ]);
        ;
            
        $builder
            ->add('customer', CustomerType::class, []);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([     
        ]);
    }
}