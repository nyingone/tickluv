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
    
    protected $session;
    protected $customer;
    protected $bookingOrders = [];

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

       if (is_array($this->error_list) && !empty($this->error_list) )
       {
        $this->session->set('customer_error', $this->error_list);
       }
    }

    /**
     * Undocumented function
     *
     * @param [object] $customer
     * @return object
     */
    public function inzCustomer($customer = null ) : object
    {
       
        if ($customer == null)
        {   
            $this->customer = new Customer();
            
            $this->inzBookingOrder() ; 

        } else{
            $this->customer = $customer;
        }

        $this->sessionSet('customer', $this->customer);
       
        return $this->customer;
    }

    /**
     * Undocumented function
     *
     * @param 
     * @return 
     */
    
    public function inzBookingOrder()
    {
        $bookingOrder = $this->bookingOrderAuxiliary->inzBookingOrder($this->customer);  
        $this->customer->addBookingOrder($bookingOrder);
    }
 
    /**
     * @Param  
     * @return 
     */
    public function refreshCustomer($customer) : void
    {
        $this->errorList = [];
        $bookingOrders = $customer->getBookingOrders(); 

        foreach ($bookingOrders as $bookingOrder) {
          $this->bookingOrderAuxiliary->refreshBookingOrder($bookingOrder);     
        }
        $this->addError();   
        $this->sessionSet();
    }
   
    

    function addError()
    {
        $errors = $this->validator->validate($this->customer);
        if (count($errors) > 0) 
        {
             $this->error_list[] = (string) $errors;
        }

    }



}