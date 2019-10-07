<?php

namespace App\Interfaces;


interface CustomerRepositoryInterface
{
    public function find(int $id);
    
}