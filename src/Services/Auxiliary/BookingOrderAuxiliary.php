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
    
    protected $paramService;
    protected $scheduleService;
    protected $closingPeriodService;

    private $closedPeriods = [];
    private $bookingStart ;
    private $bookingEnd;


    private $bookingOrderAmount = 0;

    public function __construct(SessionInterface $session, BookingOrderRepositoryInterface $bookingOrderRepository, ClosingPeriodService $closingPeriodService)
    {
        $this->bookingOrderRepository = $bookingOrderRepository;
        $this->closingPeriodService = $closingPeriodService;
        $this->session = $session;
        $this->findDefault(); 

    }

    public function headControl($bookingOrder = null)
    {
        $error = [];
        $error[] = $this->expectedDateCtl($bookingOrder->getExpectedDate());
        $error[] = $this->partTimeCodeCtl($bookingOrder->getPartTimeCode());
        $error[] = $this->visitorCountCtl($bookingOrder->getVisitorCount());
        
        return $error;
    }
    
    public function expectedDateCtl($expectedDate = null): array
    {
        if ($expectedDate == null):
            return (['danger', 'Choose a day of visit!']);
        else:
            if($this->closedPeriods.some($expectedDate)):
                return (['danger', 'This is a closed period!']);
            else:

            endif;
        endif;
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
         // GET CLOSED BOOKING PERIODS 
        $this->closedPeriods = $this->closingPeriodService->findClosedPeriods();
        
         // GET  BOOKING DLY
        $this->bookingStart = new \Datetime();
        $end = new \DateTime('+1 month'); // Default value       

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
   



}