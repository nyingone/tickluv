<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\BookingOrder;
use App\Entity\Customer;
use App\Form\HomeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, SessionInterface $session )
    {
        
        $customer = new Customer;
        $bookingOrder = new Bookingorder;
        $visitor = new Visitor;
       
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($visitor);
        $entityManager->persist($bookingOrder);
        $entityManager->persist($customer);
        $home = null;
        //
      

        $form = $this->createForm(HomeType::class, $home);

        $form->handleRequest($request);

       //  $entityManager->persist($Customer);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($visitor);
            $entityManager->persist($bookingOrder);
            $entityManager->persist($customer);

            $session->set('Customer', $customer);
            // TO DO
        }
               return $this->render('home/index.html.twig', [ 'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }
}
