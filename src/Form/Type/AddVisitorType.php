<?php
declare(strict_types=1);

namespace App\Form\Type;

use App\Domain\DTO\NewVisitorDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AddVisitorType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('lastName',  TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('birthDate', BirthdayType::class, [
                'constraints' => [
                    new Date()
                ]
            ])
            ->add('country', CountryType::class, array(
            'preferred_choices' => array('FR'),
            ))
            ->add('discounted', CheckboxType::class, [
                'label'    => 'Elligible to discount?',
                'required' => false,
            ])
        ;
    /* $builder->add('save', ResetType::class, array( 
            'attr' => array('class' => 'save'), 
            ));*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewVisitorDTO::class,
            'empty_data' => function(FormInterface $form){
                return new NewVisitorDTO(
                    $form->get('firstName')->getData(),
                    $form->get('lastName')->getData(),
                    $form->get('birthDate')->getData(),
                    $form->get('country')->getData(),
                    $form->get('discounted')->getData()
                );
            }
        ]);
    }
    
    
}



