<?php

namespace App\Services;



use Doctrine\ORM\EntityManagerInterface;

class AbstractAuxiliary
{

    protected $session;
    protected $entityManager;

    public function __construct( EntityManagerInterface $entityManager= null)
    {
      
     $this->entityManager = $entityManager;       
    }

   
}


