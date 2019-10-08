<?php

namespace App\Validator\Constraints;

use App\Services\ParamService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class IsValidPartTimeCodeValidator extends ConstraintValidator
{

    private $paramService;
    protected $partTimeCodes= [];
    protected $paramList;


    public function __construct(ParamService $paramService)
    {
        $this->paramService = $paramService;
        $this->paramList = $this->paramService->findPartTimeCodes();
        
        array_push($this->paramList, $this->partTimeCodes);

    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsValidPartTimeCode){
            throw new UnexpectedTypeExection($constraint, IsValidPartTimeCode::class); 
        }

        if (!int($value) >= 0) {
            throw new UnexpectedValueException($value,'type');
        }
        
        dd('hello', $value, $this->paramList);
        if(!in_array($value, $this->partTimeCodes)):
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ $this->paramList }}', $value)
            ->addViolation();
        endif;
    }
}