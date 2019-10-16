<?php declare(strict_types=1);

namespace App\Form\Type;

use App\Form\Type\PartTimeCodeType;
use Symfony\Component\Form\FormEvent;
use App\Domain\DTO\NewBookingOrderDTO;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use App\Validator\Constraints\BookingDateIsOpen;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use App\Validator\Constraints\PartTimeCodeIsValid;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use App\Validator\Constraints\BookingWishIsAcceptable;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddBookingOrderType extends AbstractType
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
                    new Date(),
                    new BookingDateIsOpen()
                ]
            ])
            ->add('partTimeCode', PartTimeCodeType::class, [
                'attr' => ['class' => 'form-control',  'required' => false,],
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('wishes', IntegerType::class, [
                'attr' => [ 'type' => 'number', 'step' => 1, 'mapped' => false],
                'constraints' => [
                    new Positive(),
                    new BookingWishIsAcceptable()
                ]
            ])
            ;
            $builder->get('expectedDate')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $form->getParent()->add('visitors', CollectionType::class, [
                        'entry_type' =>AddVisitorType::class,
                        'entry_options' => ['label' => false],
                        'by_reference' => false,
                        'allow_add' => true,
                        'allow_delete' => true
                    ]);
                }
            );
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewBookingOrderDTO::class,
            'empty_data' => function(FormInterface $form){
                if($form->getData() !== null): dd($form->getData()); endif;
                return new NewBookingOrderDTO(
                    $form->get('wishes')->getData(),
                    $form->get('expectedDate')->getData(),
                    $form->get('partTimeCode')->getData(),
                    $form->get('visitors')->getData()
                );
            }
        ]);
    }
}
