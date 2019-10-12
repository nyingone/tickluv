<?php

namespace App\Validator\Constraints;

use App\Entity\Visitor;

use Symfony\Component\Validator\Constraint;
use App\Services\Auxiliary\VisitorAuxiliary;
use App\Validator\Constraints\VisitorIsRegistered;
use Symfony\Component\Validator\Constraints\DateValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class VisitorIsRegisteredValidator
{

    private $visitorAuxiliary;
    private $dateValidator;

    public function __construct(VisitorAuxiliary $visitorAuxiliary, DateValidator $dateValidator)
    {
        $this->visitorAuxiliary = $visitorAuxiliary;
        $this->dateValidator = $dateValidator;
    }


    public function validate(Visitor $visitor, Constraint $constraint)
    {
        if (!$constraint instanceof VisitorIsRegistered)
        {
            throw new UnexpectedTypeException($constraint,  VisitorIsRegistered::class);

        }
        if (!is_object( $visitor)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($visitor, 'objet');
        }
    
   
        if(!is_string($visitor->getFirstName()) || !is_string($visitor->getLastName())):
            $this->context->buildViolation($constraint->msgLastOrFirstnameIsMissing)
            ->setParameter('{{ available }}',$this->availableVisitorNumber)
            ->addViolation();
        endif;

        $value = $visitor->getBirthdate();
        $constraintX = new Constraint;
        $this->dateValidator->validate($value, $constraintX);

    


    }
}