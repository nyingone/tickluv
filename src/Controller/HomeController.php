<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\BookingOrder;
use App\Entity\Customer;
use App\Form\CustomerType;
use App\Services\Customer\CustomerAuxiliary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{

    private $entityManager;

 
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, CustomerAuxiliary $customerAuxiliary, SessionInterface $session)
    {
       // $session->setName('Anonymous');
        $customer = $customerAuxiliary->setCustomer();
       //  $customer =  $session->get('Customer');
        // dd($session, $customer);
        //
        
        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){    

            $entityManager = $this->getDoctrine()->getManager();   
           
            $entityManager->persist($customer);
            $session->set('Customer', $customer);
            // dd($customer);
            // TO DO
        }
        
        return $this->render('home/index.html.twig', [ 'controller_name' => 'HomeController',
        'form' => $form->createView(),
        ]);
    }
}
