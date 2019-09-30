<?php

namespace App\Services\Customer;


use App\Services\AbstractAuxiliary;
use App\Entity\Customer;
use App\Entity\BookingOrder;
use App\Entity\Visitor;
use App\Services\Param\ParamAuxiliary;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class CustomerAuxiliary extends AbstractAuxiliary
{
    private $bookingOrderCount = 0;
    private $totalAmount = 0;
    
    protected $customer;
    protected $bookingOrder;

    const KBON = 'bookingOrderNumber'; // K to access & increment Booking Number in Param Table

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session )
    {
        // parent::__construct($entityManager);
        $this->session = $session;  

        
          
    }

    public function sessionSet($name = null , $content = null) : void
    {
        if($name == null || $content == null){
            $name = 'customer';
            $content = $this->customer;
        }
        $this->session->set($name, $content);
    
    }

    public function setCustomer($customer = null ) : object
    {
       
        if ($customer == null)
        { 
            $customer = new Customer();  
            $this->customer = $customer;
            
            $this->addBookingOrder() ; 

        } else{
            $this->customer = $customer;
        }

        $this->sessionSet('cutomer', $customer);
       
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


    /**
     * @Param  
     * @return object
     */
    public function refreshCustomer($form) : object
    {
       // $this->entityManager = getDoctrine()->getManager(Customer::class); 
       $this->customer = $form->getData();
       if($this->customer->getBookingRef() == null){
            $this->ParamAuxiliary->getNumber(KBON);
       }
       // dd($this->customer);
       $bookingOrders = $this->customer->getBookingOrders();
       dd($bookingOrders);
       foreach ($bookingOrders as $bookingOrder) {
            $visitors = $bookingOrder->getVisitors();

            foreach($visitors as $visitor){
                dd($visitor);
                $this->entityManager->persist($visitor);
                $bookingOrder->addVisitor($visitor);
            }
            $this->entityManager->persist($bookingOrder);
            $this->customer->addBookingOrder($bookingOrder);
        }

        $this->entityManager->persist($this->customer);
    
       dd($form->getData(), $this->customer);
       $this->entityManager->persist($this->customer);
      
     
        
        if($form):
          
            $this->entityManager->flush($this->customer);
        endif;

        $this->sessionSet();
        return $this->customer;
    }
   
    

}