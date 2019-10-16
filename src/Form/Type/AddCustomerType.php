<?php

namespace App\Form\Type;

use App\Domain\DTO\NewVisitorDTO;
use App\Domain\DTO\NewCustomerDTO;
use App\Form\Type\AddBookingOrderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddCustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('firstName', null , ['required' => false,])
            ->add('lastName', null , ['required' => false,])
        ;
        $builder->add('bookingOrders', CollectionType::class, [
            'entry_type' => AddBookingOrderType::class,
            'entry_options' => ['label' => false],
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewCustomerDTO::class,
            'empty_data' => function(FormInterface $form){
                return new NewCustomerDTO(
                    $form->get('email')->getData(),
                    $form->get('firstName')->getData(),
                    $form->get('lastName')->getData(),
                    $form->get('bookingOrders')->getData()
                );
            }
        ]);
        
    }
}
