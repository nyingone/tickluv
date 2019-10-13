<?php

namespace App\Services;

use App\Entity\Pricing;
use App\Interfaces\PricingRepositoryInterface;

class PricingService
{

    private $pricingRepository;
    private $paramService;
    private $tarifDate;
    private $cost = null;

 
    public function __construct(PricingRepositoryInterface $pricingRepository, ParamService $paramService)
    {
        $this->pricingRepository = $pricingRepository;
        $this->paramService= $paramService;
        
    }


    public function findLastTarifDate($date = null)
    {
        if($date == null):
            $date = new \datetime();
        endif;

        $tarifDates = $this->pricingRepository->findLastTarifDate($date);
        $tarifDate  = $tarifDates[0];
        foreach($tarifDate as $item => $date):
            $this->tarifDate = new \datetime($date);
        endforeach;
    }
/**
 * get one or a group of terms for a tarif
 *
 * @param [date] $date
 * @param [int] $partTimeCode
 * @param [boolean] $discounted
 * @param [int] $age
 * @return [mixed] $cost
 */
    public function findVisitorTarif($date = null, $partTimeCode, $discounted, $age) 
    {
        $this->findLastTarifDate($date);

    //    fetch pricing partTimeCode is null or = 
        
        $pricings = $this->pricingRepository->findLastPricing($this->tarifDate, $partTimeCode, $discounted, $age);
     
        foreach ($pricings as $pricing)
        { 
            if( ($age >= $pricing->getAgeMin() && $age < $pricing->getAgeMax()) &&
                ($pricing->getPartTimeCode() == null || $partTimeCode = $pricing->getPartTimeCode()) )
            {
                $this->cost = $pricing->getPrice();
                if( ($pricing->getPartTimeCode() == null) && ($partTimeCode !==0) ):               
                    $this->cost = $this->cost / $partTimeCode;
                endif;
            }  
        }
        return $this->cost;
    }

}