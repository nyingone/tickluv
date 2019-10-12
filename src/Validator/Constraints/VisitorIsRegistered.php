<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class VisitorIsRegistered extends Constraint
{
    public $msgLastOrFirstnameIsMissing = 'Visitor_ Firstname or lastname is required and missing';
    public $msgDateOfBirthIsMissing = 'Visitor_BirthDate is required and missing';
    public $msgCountryIsMissing = 'Visitor_country is required and missing';



    public function validateBy()
    {
        return 'validator.visitor_is_registered';
    }

    public function getTargets()
    {
        return self::CLAS_CONSTRAINT;
    }
}