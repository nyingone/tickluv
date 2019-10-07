<?php

namespace App\Interfaces;


interface BookingOrderRepositoryInterface
{
    public function find(int $id);
}