<?php

namespace App\Controller;

use App\Form\BookingData;
use App\Entity\BookingOrder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @Method({"GET"})
     */
    public function index(Request $request)
    {
        $bookingOrder = new BookingOrder;
        $form = $this->createForm(BookingData::class, $bookingOrder);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'form' => $form->createView(),
        ]);
    }
}
