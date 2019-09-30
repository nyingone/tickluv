<?php

namespace App\Services;

use App\Entity\BookingOrder;
use App\Entity\ClosingPeriod;
use App\Entity\Schedule;
use App\Entity\Param;


class BookingDisponibility
{

    private $router;

    public function load(CalendarEvent $calendar, LoggerInterface $logger): void 
    {
       
        $start = $calendar->getStart('')->format('Y-m-d');
        $end = $calendar->getEnd()->format('Y-m-d');

        $filters = $calendar->getFilters();

        // AVAILABLE BOOKING PERIOD
        $start = Datetime(today);
        $end = new \DateTime();
        $end = new \DateTime('+1 month'); // Default value
      
        // BOOKING DELAY ==> LAST BOOKING DATE
        $params = $this->getDoctrine()
        ->getRepository(Param::class)
        ->findOneBy(['refCode'  => "maxBookingOrderDly" ], ['id' => 'DESC']);

        $param = $params;

        // $end = new \DateTime(+ $param->getNumber() month);
        $interval = new \DateInterval("P". $param->getNumber() ."M");
        $end->add($interval);

        if($param->getDayNum() === "XX"){
            $last = new \DateTime($end->format('Y-m-t'));
        }
        
        
        // IMPERATIVE END DAY OF BOOKING 
        $params = $this->getDoctrine()
            ->getRepository(Param::class)
            ->findBy(['ref_code' => "maxBookingDate" ]);

        // CLOSING PERIODS
        $closingPeriods = $this->getDoctrine()
            ->getRepository(ClosingPeriod::class)
            ->findAll();


         // GET RESERVED SEATS per DAY on AVAILABLE BOOKING PERIOD
        $bookings = $this->getDoctrine()
            ->getRepository(BookingOrder::class)
            ->findDaysEntriesFromTo($start, $end);

      
            // present AVAILABLE SEATS instead of RESERVED ONE
        foreach ($bookings as $booking)
        {
            $dayEntry = new Event(
                $booking['p.expectedDate'],
                $booking['p.visitorCount']
            );
        }
        
        // add custom options
        $dayEntry->setOptions([
            'backgroundColor' => 'green',
            'borderColor' => 'green',
          ]
         );

        $dayEntry->addOption(
            'url',
            $this->router->generate('admin.booking.show', ['id' => $booking->getId(),])
        );


//  add t to the CalendarEvent to fill the calendar
        $calendar->addEvent($dayEntry);
       
    }
}