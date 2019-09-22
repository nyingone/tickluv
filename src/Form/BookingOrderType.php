<?php

namespace App\Form;

use App\Entity\BookingOrder;
use App\Form\CustomerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expectedDate')
            ->add('partTimeCode')
            ->add('ticketCount')
            ->add('customer', CustomerType::class)
        ;

        $builder->add('visitors', CollectionType::class, [
            'entry_type' => VisitorType::class,
            'entry_options' => ['label' => false],
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingOrder::class,
        ]);
    }
}
