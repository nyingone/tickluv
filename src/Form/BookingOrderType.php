<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\BookingOrder;
use App\Form\Type\PartTimeCodeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Validator\Constraints\BookingDateIsOpen;
use App\Validator\Constraints\BookingCountIsAvailable;
use App\Validator\Constraints\PartTimeCodeIsValid;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;


class BookingOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
 
    
    {
        $builder
            ->add('expectedDate', DateType::class, [
                'widget' => 'single_text',
                 // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                 // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker', 
                'id' => 'datepicker',
                'placeholder' => 'select a date',
                ],
                'constraints' => [
                    new NotBlank(),
                    new BookingDateIsOpen()
                ]
            ])
            ->add('partTimeCode', PartTimeCodeType::class, [
                'attr' => ['class' => 'form-control',  'required' => false,],
                'constraints' => [
                    new NotBlank
                ]
            ])
            ->add('visitorCount', NumberType::class, [
                'attr' => ['class' => 'form-control', 'type' => 'number', 'step' => "8"],
                'constraints' => [
                    new Positive(),
                    new BookingCountIsAvailable(),
                ]
            ])
            -> add('visitors', CollectionType::class, [
                'entry_type' => VisitorType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ]);
    }
    

        

        
        
        /*
        $builder->add('visitors', CollectionType::class, [
            'entry_type' => VisitorType::class,
            'entry_options' => ['label' => false],
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ]);
        */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookingOrder::class,
            'choices' => [
               
            ],
        ]);
      
    }
}
