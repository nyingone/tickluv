<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BookingOrder;
use App\Service\ReviewMessage;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function index(ReviewMessage $message)
    {
        $live_confirmation = $message->ConfirmationMessage('test', 'destination');

        $this->addFlash('Review approved and paid booking order', $live_confirmation);
  
        return $this->render('confirmation/index.html.twig', [
            'controller_name' => 'ConfirmationController',
        ]);
    }
}
