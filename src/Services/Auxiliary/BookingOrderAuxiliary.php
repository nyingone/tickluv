<?php

namespace App\Services\Auxiliary;

use App\Entity\BookingOrder;
use App\Services\ParamService;
use App\Services\ScheduleService;
use App\Services\ClosingPeriodService;
use App\Interfaces\BookingOrderRepositoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class BookingOrderAuxiliary
{
    private $bookingOrderRepository;
    private $bookingOrder;
    protected $visitorAuxiliary;
    
    protected $paramService;
    protected $scheduleService;
    protected $closingPeriodService;

    private $closedPeriods = [];
    private $bookingStart ;
    private $bookingEnd;


    private $bookingOrderAmount = 0;

    public function __construct(SessionInterface $session, BookingOrderRepositoryInterface $bookingOrderRepository, ClosingPeriodService $closingPeriodService, VisitorAuxiliary $visitorAuxiliary)
    {
        $this->bookingOrderRepository = $bookingOrderRepository;
        $this->visitorAuxiliary = $visitorAuxiliary;
        $this->closingPeriodService = $closingPeriodService;
        $this->findDefault(); 

    }


    public function inzBookingOrder($customer, $bookingOrder = null): object
    {   
        if ($bookingOrder == null)
        {
            $this->bookingOrder= new BookingOrder();  
            $visitor = $this->visitorAuxiliary->inzVisitor($this->bookingOrder);  
            $this->bookingOrder->addVisitor($visitor);
        } else {
            $this->bookingOrder = $bookingOrder;         
        }

        $this->bookingOrder->setCustomer($customer);

        if  ($bookingOrder !== null) : 
            $this->headControl();
        endif;
    
        return $this->bookingOrder;         
    }

    public function headControl()
    {
        $error = [];
        $error[] = $this->expectedDateCtl($this->bookingOrder->getExpectedDate());
        $error[] = $this->partTimeCodeCtl($this->bookingOrder->getPartTimeCode());
        $error[] = $this->visitorCountCtl($this->bookingOrder->getVisitorCount());
        
        return $error;
    }
    
    public function expectedDateCtl($expectedDate = null)
    {
       
       
    }

    public function partTimeCodeCtl($partTimeCode = null)
    {
        if ($partTimeCode == null):
            return (['danger', 'Choose a fullDay or part Time visit !']);
        endif;
    }

    public function visitorCountCtl($visitorCount = null)
    {
        if ($visitorCount == null):
            return (['danger', 'Choose a fullDay or part Time visit !']);
        endif;
    }

    public function findDefault()
    {    

         // GET MAX RESERVED SEATS per DAY on AVAILABLE BOOKING PERIOD
        

        // SET AVAILABLE SEATS per DAY
    }

    public function findOrders()
    {
        $bookingOrders = $this->bookingOrderRepository->findAll();

    }

    public function updateBookingOrder(BookingOrder $bookingOrder): void
    {
        $this->bookingOrderRepository->save($bookingOrder);
    }

    public function load(): void 
    {
       
       // Default value
      
        // BOOKING DELAY ==> LAST BOOKING DATE
        /* $params = $this->getDoctrine()
        ->getRepository(Param::class)
        ->findOneBy(['refCode'  => "maxBookingOrderDly" ], ['id' => 'DESC']); */

              // $end = new \DateTime(+ $param->getNumber() month);
        /* $interval = new \DateInterval("P". $param->getNumber() ."M");
        $end->add($interval);

        if($param->getDayNum() === "XX"){
            $last = new \DateTime($end->format('Y-m-t'));
        }
        */
        
        
        // IMPERATIVE END DAY OF BOOKING 
        /* $params = $this->getDoctrine()
            ->getRepository(Param::class)
            ->findBy(['ref_code' => "maxBookingDate" ]); */


    }
   
    public function findGlobalVisitorCount(BookingOrder $bookingOrder): array
    {

        return $this->bookingOrderRepository->findDaysEntriesFromTo($bookingOrder->getExpectedDate(), $bookingOrder->getExpectedDate());

    }


}