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


    public function sessionSet()
    {
        if (is_array($this->error_list) && !empty($this->error_list) )
        {
            $error_list0 = $this->session->get('customer_error');
            if ( !is_array($error_list0) || empty($error_list0) ):
                $error_list = $this->error_list;
            else:
                $error_list = array_merge($error_list0 , $this->error_list);
            endif;

            $this->session->set('booking_error', $error_list);
        }
    }

    public function inzBookingOrder(): object
    {    
        $this->bookingOrder= new BookingOrder();         
        $this->bookingOrder->setOrderDate( $this->bookingOrderStartDate);
  
        return $this->bookingOrder;         
    }


    public function refreshBookingOrder($bookingOrder)
    {
        $this->error_list = [];
        if ($this->bookingRef == null) 
        {
            $this->bookingRef = $this->session->get('_csrf/customer');
        }

        $bookingOrder->setBookingRef($this->bookingRef);

        $visitors = $bookingOrder->getVisitors();

        if ($visitors == null)
        {
            $visitor = $this->visitorAuxiliary->inzVisitor();     
            $bookingOrder->addVisitor($visitor);     
        } else {
            foreach($visitors as $visitor){
                $this->visitor = $this->visitorAuxiliary->refreshVisitor($visitor);     
            }
        }

        $this->bookingOrderRepository->save($bookingOrder);
        $this->actBookingOrderControl($bookingOrder);
        $this->session->set('bookingOrder_error', $this->error_list);

        return $bookingOrder;      
    }

    
    public function removeBookingOrder($bookingOrder): void
    {
        $this->bookingOrderRepository->remove($bookingOrder);
    }

    public function actBookingOrderControl($bookingOrder)
    {
        $errors = $this->validator->validate($bookingOrder);
        if (count($errors) > 0) 
        {
             $this->error_list[] = (string) $errors;
        }

        
    }

    public function findOrders()
    {
      return  count($bookingOrders = $this->bookingOrderRepository->findAll());
    }

   
   
    public function findGlobalVisitorCount(BookingOrder $bookingOrder): array
    {

        return $this->bookingOrderRepository->findDaysEntriesFromTo($bookingOrder->getExpectedDate(), $bookingOrder->getExpectedDate());

    }


}