<?php

namespace App\Services\Customer;


use App\Services\AbstractAuxiliary;
use App\Entity\Customer;
use App\Entity\BookingOrder;
use App\Entity\Visitor;
use App\Services\Param\ParamAuxiliary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerAuxiliary extends AbstractAuxiliary
{
    private $bookingOrderCount = 0;
    private $totalAmount = 0;
    
    protected $customer;
    protected $bookingRef;
    protected $bookingOrderStartDate;
    protected $bookingOrders;

    protected $validator;
    protected $error_list =[];



    protected $visitorAuxiliary;
    protected $bookingOrderAuxiliary;

    const KBON = 'bookingOrderNumber'; // K to access & increment Booking Number in Param Table

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, ValidatorInterface $validator, VisitorAuxiliary $visitorAuxiliary )
    {
        parent::__construct($entityManager);
        $this->session = $session;     
        $this->validator = $validator ;  
        $this->visitorAuxilliary = $visitorAuxiliary ;  
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
     * @return []
     */
    public function refreshCustomer($form) : array
    {
      //  $this->entityManager = getDoctrine()->getManager(); 
       $this->customer = $form->getData();
      
        if ($this->bookingRef == null) {
         $this->bookingRef = $this->session->get('_csrf/customer');
         $this->bookingOrderStartDate = new \DateTime('now');
        }
        $this->bookingOrders = $this->customer->getBookingOrders();
    
        foreach ($this->bookingOrders as $bookingOrder) {
          // if ($bookingOrder->getOrderNumber() == null) {
          //     $this->ParamAuxiliary->getNumber(KBON);
          //  }
            
            $bookingOrder->setBookingRef($this->bookingRef);
            $bookingOrder->setOrderDate($this->bookingOrderStartDate);
            $visitors = $bookingOrder->getVisitors();

            foreach($visitors as $visitor){
            
                $visitor->setCreatedAt($this->bookingOrderStartDate);
                $visitor->setCost($this->VisitorAuxiiary->estimateCost($visitor));

                $this->addError($this->validator->validate($visitor));
               
                // dd($visitor, $this->entityManager);
                $this->entityManager->persist($visitor);
                
                $bookingOrder->addVisitor($visitor);
            }

            $this->addError($this->validator->validate($bookingOrder));

            $this->entityManager->persist($bookingOrder);
            $this->customer->addBookingOrder($bookingOrder);
        }

        $this->addError($this->validator->validate($this->customer));
        $this->entityManager->persist($this->customer);       
        
        if($this->error_list == null):
          $this->entityManager->flush($this->customer);
        endif;

        $this->sessionSet();
        return $this->error_list;
    }
   
    

    function addError($errors)
    {
        if ($errors !== "") {
        $this->error_list[] = $errors;
    }
    }

}