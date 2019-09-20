<?php

namespace App\Form;

use App\Entity\Visitor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\component\Form\FormBuilderInterface;
use Symfony\component\OptionsResolver\OptionsResolver;

class VisitorData extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder , array $options)
    {
        $builder    
            ->add('firstName')
            ->add('lastName')
            ->add('birthdate', BirthdayType::class)
            ->add('country', CountryType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->seetDefaults([
            'data_class' => Visitor::class,
        ]);
    }
}