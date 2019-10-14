<?php

namespace App\Controller;


use App\Form\CustomerType;
use App\Services\ParamService;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Auxiliary\CustomerAuxiliary;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $customer;


   // public function __Construct( CustomerAuxiliary $customerAuxiliary)
    public function __Construct(SessionInterface $session, CustomerAuxiliary $customerAuxiliary)
    {  
        $this->paramService = $paramService;
        $this->session = $session;
        $this->customerAuxiliary = $customerAuxiliary;
        $this->customer = $customerAuxiliary->inzCustomer();
    }
    
 
    /**
     * @Route("/", name="home")
     * @Method{"GET"}
     */
    public function index(Request $request)
    {
        $form = $this->createForm(CustomerType::class, $this->customer);
        $form->handleRequest($request);
        
       //  $this->customerAuxiliary->preControlData($form->getData());
        
        if ($form->isSubmitted() && $form->isValid()){    

            $this->customer  = $form->getData();
            $this->session->remove('customer_error');
            $this->session->remove('bookingOrder_error');
            $this->session->remove('visitor_error');
            $this->customerAuxiliary->refreshCustomer($this->customer);
           
            if($this->session->get('customer_error') || $this->session->get('bookingOrder_error') || $this->session->get('visitor_error')):
            dd($this->session->get('bookingOrder_error'), $this->session->get('visitor_error') );
            else:
                return $this->redirectToRoute('confirmation');
            endif;
        }
        
        return $this->render('home/index.html.twig', [ 'controller_name' => 'HomeController',
        'form' => $form->createView(),
        ]);
    }

   public function translating($txt0)
   {
       $translator = $this->get('translator');
       $txt = $translator->trans($txt0);
       return $txt;
   }

}
