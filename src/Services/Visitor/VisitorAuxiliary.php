<?php

namespace App\Services\Visitor;


class VisitorAuxiliary
{

private $cost;
private $age;


    public function addVisitor() : void
    {

    }

    public function delVisitor() : void
    {

    }

    public function estimateCost() : float
    {
        return $this->cost;
    }

    public function estimateAge() : int
    {
        return $this->age;
    }

 
}