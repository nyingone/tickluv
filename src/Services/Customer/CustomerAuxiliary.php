<?php

namespace App\Services\Customer;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Customer;
use App\Entity\BookingOrder;
use App\Entity\Visitor;

class CustomerAuxiliary
{
    private $bookingOrderCount = 0;
    private $totalAmount = 0;
    protected $session;
    protected $customer;
    protected $bookingOrder;

    public function __construct(SessionInterface $session)
    {
     $this->session = $session;
       
    }

    public function setCustomer($customer = null )
    {
       
        if ($customer == null)
        { 
            $customer = new Customer();  
            $this->customer = $customer;
            
            $this->addBookingOrder() ; 

        } else{
            $this->customer = $customer;
        }
   
        $this->session->set('Customer', $this->customer);
        return $this->customer;
    }

    public function addBookingOrder($bookingOrder = null)
    {
        if ($bookingOrder == null)
        { 
            $bookingOrder = new BookingOrder();  
            $visitor = new Visitor();  
            $bookingOrder->addVisitor($visitor);
        }

        $this->bookingOrderCount ++;
        
        $this->customer->setBookingOrderCount($this->bookingOrderCount) ; 
        $this->customer->addBookingOrder($bookingOrder);
    }

    public function addBookingOrderAmount($amount = 0)
    {
        $this->totalAmount += $amount;
    }

    public function subBookingOrderAmount($amount = 0)
    {
        $this->totalAmount -= $amount;
    }

    public function getTotalAmount() : float
    {
        return $this->totalAmount;
    }

}