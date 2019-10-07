<?php

namespace App\Interfaces;


interface PricingRepositoryInterface
{
    public function findLastPricing($date, $partTimeCode, $discounted, $yearsOld);
}