<?php

namespace App\Services\Auxiliary;

// use App\Services\AbstractAuxiliary;

use App\Entity\Visitor;
use App\Services\PricingService;
use App\Services\Param\ParamAuxiliary;
use App\Interfaces\VisitorRepositoryInterface;

class VisitorAuxiliary 
{
    private $visitorRepository;
    private $pricingService;
      

    public function __construct(VisitorRepositoryInterface $visitorRepository, PricingService $pricingService)
    {
       $this->visitorRepository = $visitorRepository;
       $this->pricingService = $pricingService;
    }


    public function inzVisitor($bookingOrder, $visitor = null): object
    {
        if ($visitor == null)
        {
             $this->visitor = new Visitor;
        } else{
            $this->visitor = $visitor;
          
        }

        $this->visitor->setBookingOrder($bookingOrder);

        if ($visitor !== null):
            $this->visitorControl;
        endif;
       
        return $this->visitor;
    }


    public function visitorControl()
    {
        $error = [];
    }

}