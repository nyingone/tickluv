<?php

namespace App\Services\BookingOrder;

class BookingOrderAuxiliary
{

    private $bookingOrderAmount = 0;

    public function addVisitor($visitor = null)
    {

    }

    public function delBookingOrder()
    {

    }

    public function addBookingOrderAmount(float $amount)
    {
        $this->bookingOrderAmount += $amount;
    }

    public function subBookingOrderAmount(float $amount)
    {
        $this->bookingOrderAmount -= $amount;
    }
}