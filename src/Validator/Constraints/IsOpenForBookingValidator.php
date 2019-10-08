<?php

namespace App\Validator\Constraints;

use App\Services\ParamService;
use App\Services\DatComparator;
use App\Services\ScheduleService;
use App\Services\ClosingPeriodService;
use Symfony\Component\Validator\Constraint;
use App\Validator\Constraints\IsOpenForBooking;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsOpenForBookingValidator extends ConstraintValidator
{
    protected $closingPeriodService;
    private $closedPeriods = [];
    private $bookingStart ;
    private $endOfBooking ;

    protected $paramService;

    protected $scheduleService;
    private $closedDays = [];
    private $todayVisitingHours;
    protected $datComparator;

    public function __construct(ClosingPeriodService $closingPeriodService, ParamService $paramService, ScheduleService $scheduleService, DatComparator $datComparator)
    {
        $this->closingPeriodService = $closingPeriodService;
        $this->paramService = $paramService;
        $this->scheduleService = $scheduleService;
        $this->datComparator = $datComparator;
        $this->findDefault(); 
     
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsOpenForBooking) {
            throw new UnexpectedTypeException($constraint, IsOpenForBooking::class);
        }

        if (!is_object($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'date');
        }


        // if ($value == null):
        //    return (['danger', 'Choose a day of visit!']);
        // endif;
        
        $sel = true;
        if(is_array($this->closedPeriods)):
            foreach($this->closedPeriods as $closedPeriod):
                if( $this->datComparator->isHigherOrEqual($value , $closedPeriod->getFromDat0()) && $this->datComparator->isLowerOrEqual($value , $closedPeriod->getToDatex()) ):
                    $sel = false;
                endif;
            endforeach;
        endif;

        if(is_array($this->closedDays)):
            foreach($this->closedDays as $closedDay):
                if( $closedDay->getdayOfWeek() == $this->datComparator->dayOfWeek($value) ):
                    $sel = false;
                endif;
            endforeach;
        endif;

        if (((is_array($this->todayVisitingHours) && is_empty($this->todayVisitingHours))) || $this->todayVisitingHours == null ):
            if( $this->datComparator->isEqual($value)):
                $sel = false;
            endif;
        endif;

        if($sel = false):
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation(); 
        endif;
            
    }

    public function findDefault()
    {
         // GET CLOSED BOOKING PERIODS 
        $this->closedPeriods = $this->closingPeriodService->findClosedPeriods();

        $this->bookingStart = new \DateTime;

         // GET  END of BOOKING (DLY or imperative)
        $this->endOfBooking = $this->paramService->findEndOfBooking();

         // GET CLOSED DAYS OF WEEK
         $this->closedDays = $this->scheduleService->findClosedDays();

         // FIND TODAY Allowed Booking versus VisitingHours
         $this->toDaySchedule = $this->scheduleService->findTodayVisitingHours();

    }
}