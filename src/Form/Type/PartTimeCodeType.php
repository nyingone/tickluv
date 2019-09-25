<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartTimeCodeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Fullday     -Full tarif' => '0',
                'Halfday     -Full tarif' => '1',
                'Halfday     -Half tarif' => '2',
            ],
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}