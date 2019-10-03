<?php

namespace App\Services\Visitor;


class VisitorAuxiliary extends AbstractAuxiliary
{

private $cost;
private $age;


    public function estimateCost() : float
    {
        return $this->cost;
    }

    public function estimateAge() : int
    {
        return $this->age;
    }

 
}