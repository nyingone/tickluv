<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Form\BookingOrderType;
use App\Entity\BookingOrder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request)
    {
        $bookingOrder = new BookingOrder;
        $visitor1 = new Visitor();
        $visitor1->setFirstName('Dummy');
        $visitor1->setLastName('FalseName');
        $visitor1->setBirthDate(new\datetime);
        $visitor1->setCountry('FR');
        //
        $form = $this->createForm(BookingOrderType::class, $bookingOrder);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'form' => $form->createView(),
        ]);
    }
}
