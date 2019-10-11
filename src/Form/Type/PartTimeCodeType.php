<?php
namespace App\Form\Type;

use App\Services\ParamService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PartTimeCodeType extends AbstractType
{
    
    private $paramService;
    protected $partTimeArray= [];
    protected $partTimeList;
    
    
    public function __construct(ParamService $paramService )
    {
        $this->paramService = $paramService;
        $this->partTimeArray = $this->paramService->findPartTimeArray();  
    
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => $this->partTimeArray,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}