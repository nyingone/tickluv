<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\BookingOrder;
use App\Form\BookingOrderType;
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
        $BookingOrder = new BookingOrder;
       
        $entityManager = $this->getDoctrine()->getManager();
        $visitor1 = new Visitor();
        $visitor1->setFirstName('Dummy');
        $visitor1->setLastName('FalseName');
        $visitor1->setBirthDate(new\datetime);
        $visitor1->setCountry('FR');
        $BookingOrder->addVisitor($visitor1);
        
        //
      

        $form = $this->createForm(BookingOrderType::class, $BookingOrder);

        $form->handleRequest($request);

        $entityManager->persist($BookingOrder);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($BookingOrder);
            $session->set('Booking', $BookingOrder);
            dump($session); die;
            // TO DO
        }
               return $this->render('home/index.html.twig', [ 'controller_name' => 'indexController',
            'form' => $form->createView(),
        ]);
    }
}
