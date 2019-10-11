<?php

namespace App\Services\Auxiliary;

// use App\Services\AbstractAuxiliary;

use App\Entity\Visitor;
use App\Services\PricingService;
use App\Services\Param\ParamAuxiliary;
use App\Interfaces\VisitorRepositoryInterface;

class VisitorAuxiliary 
{
    private $visitorRepository;
    private $pricingService;
      

    public function __construct(VisitorRepositoryInterface $visitorRepository, PricingService $pricingService)
    {
       $this->visitorRepository = $visitorRepository;
       $this->pricingService = $pricingService;
    }


    public function inzVisitor(): object
    {
        $visitor = new Visitor;
        $visitor->setCreatedAt($this->getBookingOrder()->getStartDate());
        return $visitor;

    }

    public function refreshVisitor($visitor): object
    {
        
        $cost = $this->pricingService->getVisitorTarif($visitor->getPartTimeCode(), $visitor->getDiscounted(),$visitor->getAge()) ;
        $visitor->setCost($cost);
                
    
        $visitor->setCost($this->pricingService->findVisitorTarif(
            $visitor->getBookingOrder()->getStartDate(),
            $visitor->getBookingOrder()->getPartTimeCode(), 
            $visitor->getDiscounted(), 
            $visitor->getAge())) ;

        $this->visitorRepository->save($visitor);
        
        return $visitor;
    }

    public function removeVisitor($visitor): void
    {
        $this->visitorRepository->remove($visitor);
    }

   

    public function actVisitorControl($visitor)
    {
        return $this->validator->validate($visitor);
    }

    
}