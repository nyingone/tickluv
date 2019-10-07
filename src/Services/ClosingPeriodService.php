<?php

namespace App\Services;

use App\Interfaces\ClosingPeriodRepositoryInterface;


final class ClosingPeriodService
{

  private $closingPeriodRepository;
  private $closingPeriods = [];

  public function __construct(ClosingPeriodRepositoryInterface $closingPeriodRepository)
    {
       $this->closingPeriodRepository = $closingPeriodRepository;
    }

   
    public function findClosedPeriods()
    {          
      
        $this->closingPeriods = $this->closingPeriodRepository
         ->findAllClosedPeriod();

        return $this->closingPeriods;
    }


    

}
    