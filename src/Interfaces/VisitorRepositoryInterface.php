<?php

namespace App\Interfaces;


interface VisitorRepositoryInterface
{
    public function find(Visitor $visitor);
    public function save(Visitor $visitor);
    public function remove(Visitor $visitor);
    
}