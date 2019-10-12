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

    private $bookingDispo = [];
    private $customer;
    private $closingPeriodService;


   // public function __Construct( CustomerAuxiliary $customerAuxiliary)
    public function __Construct(SessionInterface $session, CustomerAuxiliary $customerAuxiliary, ParamService $paramService)
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
            $this->customerAuxiliary->refreshCustomer($this->customer);
           
            dd($this->session->get('booking_error'));
            if($this->session->get('customer_error') || $this->session->get('booking_error') || $this->session->get('visitor_error')):
                dd($this->session->get('customer_error'));
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
