<?php

namespace App\Services;

class PriceFetching
{
private $cost = 0;

   /**
    * Estimates visitors's ticket cost 
    *
    * @param Visitor
    * @return float $cost
    */
    
    public function estimateCost(Visitor $visitor)
    {
        return $this->cost;
    }
}