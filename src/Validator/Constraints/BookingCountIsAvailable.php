<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class BookingCountIsAvailable extends Constraint
{
    public const BOOKING_EXEDES_CAPACITY = 'booking_demand_exedes_day_capacity';
    public $msgBookingExedesCapacity = 'booking_demand_exedes_day_capacity';  
}