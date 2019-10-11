<?php

namespace App\Services;

use App\Interfaces\PricingRepositoryInterface;

class PricingService
{

    private $pricingRepository;
    private $today;
    private $cost = null;

 
    public function __construct(PricingRepositoryInterface $pricingRepository)
    {
        $this->pricingRepository = $pricingRepository;
        $this->today = new \datetime();
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
    public function findVisitorTarif($partTimeCode, $discounted, $age) 
    {

        $pricings = $this->pricingRepository->findLastPricing($this->today, $partTimeCode, $discounted, $age);
        
        foreach ($pricings as $pricing)
        {
            if ($age >= $pricing->getAgeMin() && $age < $pricing->getAgeMax())
            {
                $this->cost = $pricing->getCost();
            }
               
        }
        return $this->cost;
    }



}