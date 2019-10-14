<?php

namespace App\Form;

use App\Entity\Visitor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitorType extends AbstractType
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
            'data_class' => Visitor::class,
        ]);
    }
}
