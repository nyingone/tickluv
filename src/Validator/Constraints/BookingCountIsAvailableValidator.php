<?php

namespace App\Validator\Constraints;

use App\Services\ParamService;
use App\Services\DatComparator;
use Symfony\Component\Validator\Constraint;
use App\Services\Auxiliary\BookingOrderAuxiliary;
use Symfony\Component\Validator\ConstraintValidator;
use App\Validator\Constraints\ BookingCountIsAvailable;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class BookingCountIsAvailableValidator extends ConstraintValidator
{
    private $paramService;
    private $bookingOrderService;
    private $maxVisitors ;
    private $maxBookingVisitors;
    private $availableVisitorNumber;
    private $datComparator ;

    public function __construct( ParamService $paramService, BookingOrderAuxiliary $bookingOrderAuxiliary,  DatComparator $datComparator )
    {
        
        $this->paramService = $paramService;
      

        $this->datComparator = $datComparator;
        $this->bookingOrderAuxiliary = $bookingOrderAuxiliary;   
      
    }

    public function validate($value, Constraint $constraint)
    {
        $this->bookingOrder = $value;

        if (!$constraint instanceof  BookingCountIsAvailable) {
            throw new UnexpectedTypeException($constraint,  BookingCountIsAvailable::class);
        }

        if (!is_object($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'bookingOrder');
        }

        $this->findAvailableVisitorNumber();  
        if ($this->bookingOrder->getVisitorCount() > $this->maxBookingVisitor)
        {
            $this->context->buildViolation($constraint->msgBookingExedesCapacity)
                ->setParameter('{{ string }}'," ")
                ->addViolation(); 
        } else  {

            if( $this->availableVisitorNumber < $this->bookingOrder->getVisitorCount()  ):
                $this->context->buildViolation($constraint->msgBookingExedesCapacity)
                ->setParameter('{{ string }}'," ")
                ->addViolation(); 
            endif;
        }                  
    }

    public function findAvailableVisitorNumber()
    {
        dd($this->bookingOrder);
        $this->maxVisitors = $this->paramService->findMaxVisitors();
        $this->maxBookingVisitors = $this->paramService->findMaxBookingVisitors();

        $tstDate = $this->datComparator->convert($this->bookingOrder->getExpectedDate());
        $tstMonth = substr($tstDate , 1, 6);
        $tstExe = substr($tstDate , 1, 4);

    
        $this->maxVisitor = 0;

        foreach($this->maxBookingvisitor as $param){
            $refDat = rtrim($param->getExenum(). $param->getMonthNum(). $param->getDayNum());

            if ($this->maxVisitor == 0 && $tstDate == $refDat) :
                $this->maxVisitor = $param->getNumber();
            endif;
            if ($this->maxVisitor == 0 && $tstMonth == $refDat ):
                $this->maxVisitor = $param->getNumber();
            endif;
            if ($this->maxVisitor == 0 && $tstExe == $refDat ):
                $this->maxVisitor = $param->getNumber();
            endif;

        }

        $this->availableVisitorNumber =  $this->maxVisitor - $this->bookingOrderAuxiliary->findGlobalVisitorCount();

    }

}