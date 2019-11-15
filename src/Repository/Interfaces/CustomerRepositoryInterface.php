<?php

namespace App\Repository\Interfaces;


interface CustomerRepositoryInterface
{
    public function find(Customer $customer);
    public function save(Customer $customer);
    public function remove(Customer $customer);
    
}