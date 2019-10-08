<?php

namespace App\Services\Auxiliary;

// use App\Services\AbstractAuxiliary;
use App\Entity\Visitor;
use App\Entity\Customer;
use App\Entity\BookingOrder;
use Symfony\Component\HttpFoundation\Request;
use App\Interfaces\CustomerRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CustomerAuxiliary 
{
    private $bookingOrderCount = 0;
    private $totalAmount = 0;
    
    protected $customer;
    protected $bookingRef;
    protected $bookingOrderStartDate;
    protected $bookingOrders;

    protected $validator;
    protected $error_list =[];

    protected $bookingOrderAuxiliary;

    const KBON = 'bookingOrderNumber'; // K to access & increment Booking Number in Param Table

  //  public function __construct(CustomerRepositoryInterface $customerRepository, SessionInterface $session, ValidatorInterface $validator, BookingOrderAuxiliary $bookingOrderAuxiliary)

    public function __construct(CustomerRepositoryInterface $customerRepository, SessionInterface $session, ValidatorInterface $validator, BookingOrderAuxiliary $bookingOrderAuxiliary)
    {
        $this->customerRepository = $customerRepository;  
        $this->session = $session;     
        $this->validator = $validator ;  
        $this->bookingOrderAuxiliary = $bookingOrderAuxiliary ;  
    }

    public function sessionSet($name = null , $content = null) : void
    {
        if($name == null || $content == null){
            $name = 'customer';
            $content = $this->customer;
        }
        $this->session->set($name, $content);
    
    }

    /**
     * Undocumented function
     *
     * @param [object] $customer
     * @return object
     */
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

    /**
     * Undocumented function
     *
     * @param Customer $customer
     * @return Customer $customer
     */
    
    public function addBookingOrder($bookingOrder = null)
    {
        if ($bookingOrder == null)
        { 
            $bookingOrder = new BookingOrder();  
          
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

    public function preControlData($data) 
    {
        $this->customer = $data;
        $this->bookingOrders = $this->customer->getBookingOrders();
        foreach($this->bookingOrders as $bookingOrder)
        {
            ($this->validator->validate($bookingOrder));
        }
       
        // dd($data);
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
        
            
            $bookingOrder->setBookingRef($this->bookingRef);
            $bookingOrder->setOrderDate($this->bookingOrderStartDate);
            $visitors = $bookingOrder->getVisitors();

            foreach($visitors as $visitor){
            
                $visitor->setCreatedAt($this->bookingOrderStartDate);
                $cost = $this->pricingService->getVisitorTarif($this->bookingOrderStartDate, $visitor->getPartTimeCode(), $visitor->getDiscounted(),$visitor->getAge()) ;
                $visitor->setCost($cost);
                

                $this->addError($this->validator->validate($visitor));
               
                // dd($visitor, $this->entityManager);
                $this->entityManager->persist($visitor);
                
                $bookingOrder->addVisitor($visitor);
            }

            $this->addError($this->validator->validate($bookingOrder));

            // $this->entityManager->persist($bookingOrder);
            $this->customer->addBookingOrder($bookingOrder);
        }

        $this->addError($this->validator->validate($this->customer));
  

        
        $this->sessionSet();
        return $this->error_list;
    }
   
    

    function addError($errors)
    {
        if ($errors !== "") {
        $this->error_list[] = $errors;
    }
    }


    public function loadCustomerByEmail($email): Customer
    {
        $customer = $this->userRepository->findOneByEmail($email);

        if ($customer !== null) {
            return $customer;
        }
        throw new Exception(
            sprintf('Email "%s" does not exist.', $email)
        );
    }
    
    
    public function validateCustomer(Customer $customer): Customer
    {
        if (!$customer instanceof User) {
            throw new Exception(
                sprintf('Instances of "%s" are not supported.', \get_class($customer))
            );
        }
        $id = $customer->getId();
        return $this->find($customer);
    }


}