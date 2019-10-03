<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\BookingOrder;
use App\Services\ReviewMessage;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function index(SessionInterface $session, ReviewMessage $message, Request $request) : response
    {
        $bookingRef =  $session->get('bookingRef');
        dd($session, $request->attributes->all());
        // TODO implementer Param converter ? 
        if($bookingRef):
            $bookingOrders=$this->getDoctrine()->getRepository(BookingOrder::class)->findByBookingRef($bookingRef);
        endif;
        
        
        return $this->render('confirmation/index.html.twig', [ 'controller_name' => 'ConfirmationController',
               'bookingOrders' => $bookingOrders,
        ]);
    
    }

    public function sendConfirmation()
    {
        $mailer = $this->container->get('mailer');

    }
}
