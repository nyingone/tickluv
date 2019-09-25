<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\HomeType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Contracts\Translation\TranslatorInterface;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request,LoggerInterface $logger, TranslatorInterface $translator)
    {
        $translated = $translator->trans('Symfony is great');
        echo($translated);
        $form = $this->createForm(HomeType::class );
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController', 'form' => $form->createView(),
        ]);
    }
}
