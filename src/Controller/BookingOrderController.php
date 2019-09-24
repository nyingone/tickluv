<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\BookingOrder;
use App\Form\BookingOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookingOrderController extends AbstractController
{
    /**
     * @Route("/booking/order", name="booking")
     */
    public function new(Request $request)
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

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($visitor1);
            // TO DO
        }
               return $this->render('booking_order/new.html.twig', [ 'controller_name' => 'BookingOrderController',
            'form' => $form->createView(),
        ]);
    }
}
