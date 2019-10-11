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
        $this->bookingOrder = $this->bookingOrderAuxiliary->inzBookingOrder($this->customer);  
        $this->customer->addBookingOrder($this->bookingOrder);
    }
 
    /**
     * @Param  
     * @return []
     */
    public function refreshCustomer($customer) : array
    {
        $this->errorList = [];
        $this->bookingOrders = $this->customer->getBookingOrders();
    
        foreach ($this->bookingOrders as $bookingOrder) {
            $this->bookingOrder =  $this->bookingOrderAuxiliary->refreshBookingOrder($bookingOrder);
            $this->addError($this->bookingOrderAuxiliary->actBookingOrderControl($this->bookingOrder));
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