<?php

namespace App\Interfaces;


interface CustomerRepositoryInterface
{
    public function find(Customer $customer);
    public function save(Customer $customer);
    public function remove(Customer $customer);
    
}