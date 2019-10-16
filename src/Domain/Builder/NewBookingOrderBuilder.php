<?php
declare(strict_types=1);

namespace App\Domain\Builder;

use App\Entity\BookingOrder;

class NewBookingOrderBuilder
{
    private $bookingOrder;

    public function create(): self
    {
        $this->bookingOrder = new BookingOrder;
        return $this;
    }

    public function getBookingOrder(): BookingOrder
    {
        return $this->bookingOrder;
    }
}