<?php

namespace App\Services\Banner;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use App\Services\Banner\HTMLMockUpBanner;

class MockUpListener
{

    protected $HTMLMockupBanner;

    protected $endDate;


    public function __construct(HTMLMockUpBanner $HTMLMockUpBanner, $endDate)
    {
        $this->HTMLMockUpBanner = $HTMLMockUpBanner;
        $this->endDate = new \Datetime($endDate);

    }

    public function processMockUp(FilterResponseEvent $event)
    {
        
        if (!$event->isMasterRequest()) {
            return;
        }

        $remainingDays = $this->endDate->diff(new \Datetime())->days;

        if ($remainingDays <= 0) {
            return;
        }
       
        $response = $this->HTMLMockUpBanner->addMockUp($event->getResponse(), $remainingDays);
    
        $event->setResponse($response);
    }

}
