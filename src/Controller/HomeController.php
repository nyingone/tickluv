<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\BookingOrder;
use App\Entity\Customer;
use App\Form\CustomerType;
use App\Services\Customer\CustomerAuxiliary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends AbstractController
{

    private $entityManager;


 
    /**
     * @Route("/", name="home")
     * @Method{"GET"}
     */
    public function index(Request $request, CustomerAuxiliary $customerAuxiliary, EntityManagerInterface $entityManager, SessionInterface $session)
    {
       
               // $session->setName('Anonymous');
        $customer = $customerAuxiliary->setCustomer();
       //  $customer =  $session->get('Customer');
        // dd($session, $customer);
        //
       
        $form = $this->createForm(CustomerType::class, $customer);
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){    
               //  dd($request);
                $errors = $customerAuxiliary->refreshCustomer($form);
                // dd($customer);
                // TO DO
                if ($errors !== false && $errors !== null){
                     return $this->redirectToRoute('confirmation');
                }
               
                
            }
        }
        return $this->render('home/index.html.twig', [ 'controller_name' => 'HomeController',
        'form' => $form->createView(),
        ]);
    }

   public function translating()
   {
       $translator = $this->get('translator');
       $txt = $translator->trans('msg');
   }

}
