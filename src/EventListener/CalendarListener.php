<?php

namespace App\EventListener;

use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;

class CalendarListener
{

    public function load(CalendarEvent $calendar)
    {
        $start = $calendar->getStart('Today');
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();
        
        /*  ??? custom qry to fill the calendar  */
        $calendar->addEvent(new Event(
            'All day event' ,
            new \Datetime('Monday this week')
        ));
    }
}