<?php

namespace App\Validator\Constraints;

use App\Services\ParamService;
use App\Services\DatComparator;
use Symfony\Component\Validator\Constraint;
use App\Services\Auxiliary\BookingOrderAuxiliary;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Validator\Constraints\ BookingDisponibility;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class BookingDisponibilityValidator extends ConstraintValidator
{
    private $paramService;
    private $bookingOrderService;
    private $maxVisitors ;
    private $availableVisitorNumber;
    private $datComparator ;

    public function __construct( ParamService $paramService, BookingOrderAuxiliary $bookingOrderAuxiliary,  DatComparator $datComparator,  SessionInterface $session )
    {
    
        $this->paramService = $paramService;
        $this->session = $session;
        $this->datComparator = $datComparator;
        $this->bookingOrderAuxiliary = $bookingOrderAuxiliary;   
     
      
    }

    public function validate($bookingOrder, Constraint $constraint)
    {    

        $this->availableVisitorNumber = $this->findAvailableVisitorNumber($bookingOrder);  

        if( ($this->availableVisitorNumber < $bookingOrder->getWishes()) || 
        ($this->availableVisitorNumber < count($bookingOrder->getVisitors)) ):
            $this->context->buildViolation($constraint->msgBookingExedesCapacity)
            ->setParameter('{{ string }}'," ")
            ->addViolation(); 
        endif;                 
    }

    public function findAvailableVisitorNumber($bookingOrder)
    {
    
        $this->maxVisitors = $this->paramService->findMaxVisitors();

        $tstDate = $this->datComparator->convert($bookingOrder->getExpectedDate());
        $tstMonth = substr($tstDate , 0, 6);
        $tstExe = substr($tstDate , 0, 4);

    
        $this->maxVisitor = 0;

        foreach($this->maxVisitors as $param){
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

        $bookedVisitors = $this->bookingOrderAuxiliary->findGlobalVisitorCount($bookingOrder);
        if( !is_integer($bookedVisitors)) : 
            $bookedVisitors = 0;
        endif;
        
        $this->availableVisitorNumber =  $this->maxVisitor - $bookedVisitors;
    
    }

}