<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class IsOpenForBooking extends Constraint
{
    public $message = 'You chose a closed booking period or day';
}