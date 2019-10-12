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


    public function sessionSet()
    {
        if (is_array($this->error_list) && !empty($this->error_list) )
        {
            $error_list0 = $this->session->get('customer_error');
            if ( !is_array($error_list0) || empty($error_list0) ):
                $error_list = $this->error_list;
            else:
                $error_list = array_merge($error_list0 , $this->error_list);
            endif;

            $this->session->set('booking_error', $error_list);
        }
    }

    public function inzVisitor(): object
    {
        $visitor = new Visitor;
        $visitor->setCreatedAt($this->getBookingOrder()->getStartDate());
        $this->addError($this->visitorAuxiliary->actVisitorControl($visitor));
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
        $this->addError($this->visitorAuxiliary->actVisitorControl($visitor));
        
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