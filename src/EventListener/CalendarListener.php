<?php

namespace App\EventListener;
use App\Entity\BookingOrder;
use App\Entity\ClosingPeriod;
use App\Entity\Schedule;
use App\Entity\Param;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;

class CalendarListener
{

    private $BookingOrderRepository;
    private $ClosingPeriodRepository;
    private $ScheduleRepository;
    private $ParamRepository;

    private $router;

    public function load(CalendarEvent $calendar): void 
    {
       
        $start = $calendar->getStart('')->format('Y-m-d');
        $end = $calendar->getEnd()->format('Y-m-d');

        $filters = $calendar->getFilters();

        // find count visitors via BookingOrder group bay day for planned period 
        $start = Datetime(today);

        $bookings = $this->getDoctrine()
            ->getRepository(BookingOrder::class)
            ->findDaysEntriesFromTo($start, $end);


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