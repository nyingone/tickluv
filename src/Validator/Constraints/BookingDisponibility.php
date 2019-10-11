<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class BookingDisponibility extends Constraint
{
    public const BOOKING_EXEDES_CAPACITY = 'booking_demand_exedes_day_capacity';
    public $msgBookingExedesCapacity = 'booking_demand_exedes_day_capacity';  


    public function validateBy()
    {
        return 'validator.booking_disponibility';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    
}