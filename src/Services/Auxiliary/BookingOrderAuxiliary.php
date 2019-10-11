<?php

namespace App\Services\Auxiliary;

use App\Entity\BookingOrder;
use App\Services\ParamService;
use App\Services\ScheduleService;
use App\Services\ClosingPeriodService;
use App\Interfaces\BookingOrderRepositoryInterface;
use Symfony\Component\Asset\Context\NullContext;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookingOrderAuxiliary
{
    private $bookingOrderRepository;
    private $bookingOrder;
    protected $visitorAuxiliary;

    protected $bookingRef;
    protected $bookingOrderStartDate;
    
    protected $session;
    protected $paramService;
    protected $scheduleService;

    private $closedPeriods = [];
    private $bookingStart ;
    private $bookingEnd;


    private $bookingOrderAmount = 0;

    public function __construct(SessionInterface $session, BookingOrderRepositoryInterface $bookingOrderRepository, VisitorAuxiliary $visitorAuxiliary, ValidatorInterface $validator)
    {
        $this->bookingOrderRepository = $bookingOrderRepository;
        $this->session = $session;
        $this->validator = $validator;
        $this->visitorAuxiliary = $visitorAuxiliary;
        $this->bookingOrderStartDate = new \DateTime('now');
    }

    public function inzBookingOrder(): object
    {    
        $this->bookingOrder= new BookingOrder();         
        $this->bookingOrder->setOrderDate( $this->bookingOrderStartDate);
  
        return $this->bookingOrder;         
    }


    public function refreshBookingOrder($bookingOrder)
    {
        if ($this->bookingRef == null) 
        {
            $this->bookingRef = $this->session->get('_csrf/customer');
        }

        $this->bookingOrder->setBookingRef($this->bookingRef);

        $visitors = $bookingOrder->getVisitors();

        if ($visitors == null)
        {
            $visitor = $this->visitorAuxiliary->inzVisitor();  
            $bookingOrder->addVisitor($visitor);
                
        } else {
            foreach($visitors as $visitor){
    
                $this->visitorAuxiliary->refreshVisitor($visitor);
           
                $this->addError($this->visitorAuxiliary->actVisitorControl($visitor));                
            }
        }

        $this->bookingOrderRepository->save($bookingOrder);
        return $bookingOrder;              
    }

    
    public function removeBookingOrder($bookingOrder): void
    {
        $this->bookingOrderRepository->remove($bookingOrder);
    }

    public function actBookingOrderControl($bookingOrder)
    {
        $this->addError($this->validator->validate($bookingOrder));   
        return $this->error_list;
    }

    public function findOrders()
    {
      return  count($bookingOrders = $this->bookingOrderRepository->findAll());
    }


    function addError($errors)
    {
        if ($errors !== "") {
        $this->error_list[] = $errors;
        }
    }

   
   
    public function findGlobalVisitorCount(BookingOrder $bookingOrder): array
    {

        return $this->bookingOrderRepository->findDaysEntriesFromTo($bookingOrder->getExpectedDate(), $bookingOrder->getExpectedDate());

    }


}